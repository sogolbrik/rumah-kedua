<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kamar;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PembayaranPenghuniController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Tampilkan halaman pembayaran tagihan jatuh tempo
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan penghuni punya kamar
        if (!$user->kamar) {
            return redirect()->route('dashboard-penghuni')->with('error', 'Anda belum memiliki kamar.');
        }

        // Cari transaksi TERAKHIR (berdasarkan tanggal_jatuhtempo terbaru) milik user
        $transaksi = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_jatuhtempo', 'desc') // Urutkan dari yang paling baru
            ->first(); // Ambil satu saja (yang terakhir)

        $dataTransaksi = null;
        $isOverdue = false;

        if ($transaksi) {
            // Cek apakah tanggal_jatuhtempo transaksi terakhir sudah lewat (kemarin atau sebelumnya)
            $isOverdue = $transaksi->tanggal_jatuhtempo < now()->toDateString();

            if ($isOverdue) {
                // Format data untuk ditampilkan di blade
                $dataTransaksi = [
                    'id' => $transaksi->id,
                    'kode' => $transaksi->kode,
                    'total_bayar' => (int) $transaksi->total_bayar,
                    'tanggal_jatuhtempo' => $transaksi->tanggal_jatuhtempo->toDateString(),
                    'periode_mulai' => Carbon::parse($transaksi->masuk_kamar)->format('M Y'),
                    'periode_akhir' => Carbon::parse($transaksi->masuk_kamar)->addMonths($transaksi->durasi - 1)->format('M Y'),
                    'kamar_kode' => $transaksi->kamar->kode_kamar ?? '–',
                ];
            }
        }

        return view('frontend.user.pembayaran-penghuni', [
            'user' => $user,
            'dataTransaksi' => $dataTransaksi,
            'isOverdue' => $isOverdue,
            'message' => !$transaksi ? 'Tidak ada transaksi ditemukan.' : (!$isOverdue ? 'Belum ada tagihan yang jatuh tempo.' : null)
        ]);
    }

    /**
     * Buat transaksi baru berdasarkan durasi pilihan user
     */
    public function buatTransaksiBaru(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'durasi' => 'required|in:1,3,6'
        ]);

        $durasi = (int) $request->durasi;

        // Ambil data kamar user untuk harga
        $kamar = $user->kamar;
        if (!$kamar) {
            return response()->json([
                'success' => false,
                'message' => 'Data kamar tidak ditemukan.'
            ], 400);
        }

        // Hitung total bayar
        $totalBayar = $kamar->harga * $durasi;

        // Hitung tanggal masuk (misalnya, dari hari ini)
        $tanggalMasuk = now()->toDateString();

        // Hitung tanggal jatuh tempo (tanggal masuk + durasi bulan - 1 hari)
        $tanggalJatuhTempo = Carbon::parse($tanggalMasuk)->addMonths($durasi)->subDays(1)->toDateString();

        // Generate kode unik
        $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');

        // Generate order ID Midtrans
        $midtransOrderId = $this->midtransService->generateOrderId($kode);

        // Buat transaksi baru
        $transaksiBaru = Transaksi::create([
            'id_user' => $user->id,
            'id_kamar' => $kamar->id,
            'kode' => $kode,
            'tanggal_pembayaran' => null, // Belum dibayar
            'tanggal_jatuhtempo' => $tanggalJatuhTempo,
            'masuk_kamar' => $tanggalMasuk,
            'durasi' => $durasi,
            'total_bayar' => $totalBayar,
            'metode_pembayaran' => 'midtrans',
            'status_pembayaran' => 'pending',
            // Kosongkan field Midtrans untuk saat ini
            'midtrans_order_id' => $midtransOrderId,
            'midtrans_transaction_id' => null,
            'midtrans_payment_type' => null,
            'midtrans_response' => null,
            'expired_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi baru berhasil dibuat.',
            'transaksi_baru' => [
                'id' => $transaksiBaru->id,
                'kode' => $transaksiBaru->kode,
                'total_bayar' => $transaksiBaru->total_bayar,
                'tanggal_jatuhtempo' => $transaksiBaru->tanggal_jatuhtempo,
                'durasi' => $transaksiBaru->durasi,
            ]
        ]);
    }

    /**
     * Siapkan pembayaran Midtrans untuk transaksi yang baru dibuat
     */
    public function bayarTagihan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id_transaksi' => 'required|exists:transaksis,id,id_user,' . $user->id
        ]);

        $id_transaksi = $request->id_transaksi;

        // Cari transaksi milik user berdasarkan ID yang dikirim
        $transaksi = Transaksi::with('kamar')
            ->where('id', $id_transaksi)
            ->where('id_user', $user->id)
            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan atau bukan milik Anda.'
            ], 404);
        }

        // Validasi total bayar
        if ($transaksi->total_bayar <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Total tagihan tidak valid.'
            ], 400);
        }

        // Ambil dan parse midtrans_response
        $midtransData = [];
        if (!empty($transaksi->midtrans_response) && is_string($transaksi->midtrans_response)) {
            $midtransData = json_decode($transaksi->midtrans_response, true);
        }

        // Cek apakah token masih valid
        $tokenExpired = true;

        if (isset($midtransData['expired_at']) && !empty($midtransData['expired_at'])) {
            try {
                $expiresAt = Carbon::parse($midtransData['expired_at']);
                $tokenExpired = now()->gte($expiresAt);
            } catch (\Exception $e) {
                $tokenExpired = true;
            }
        }

        // Jika token masih valid, kembalikan langsung
        if (!$tokenExpired && isset($midtransData['snap_token'])) {
            Log::info('Using existing valid Midtrans token for transaction ID: ' . $transaksi->id);
            return response()->json([
                'success' => true,
                'snap_token' => $midtransData['snap_token']
            ]);
        }

        // Jika token expired atau tidak ada, buat baru
        try {
            $orderId = $transaksi->midtrans_order_id;

            $transactionDetails = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $transaksi->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '081234567890',
                ],
                'item_details' => [
                    [
                        'id' => $transaksi->id,
                        'price' => (int) $transaksi->total_bayar,
                        'quantity' => 1,
                        'name' => "Pembayaran Sewa Kamar {$transaksi->kamar->kode_kamar} ({$transaksi->durasi} Bulan)",
                        'category' => 'Sewa Kost'
                    ]
                ],
                'expiry' => [
                    'start_time' => now()->format('Y-m-d H:i:s O'),
                    'unit' => 'hour',
                    'duration' => 24
                ]
            ];

            Log::info('Preparing Midtrans Transaction for ID: ' . $transaksi->id, $transactionDetails);

            $midtransResponse = $this->midtransService->createTransaction($transactionDetails);

            if (!$midtransResponse['success']) {
                throw new \Exception($midtransResponse['message'] ?? 'Gagal membuat token Midtrans');
            }

            // Simpan snap_token & expired_at ke database
            $transaksi->midtrans_response = json_encode([
                'snap_token' => $midtransResponse['snap_token'],
                'expired_at' => now()->addHours(24)->toDateTimeString(),
            ]);
            $transaksi->save();

            return response()->json([
                'success' => true,
                'snap_token' => $midtransResponse['snap_token']
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Payment Error for Transaction ID: ' . $transaksi->id, ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyiapkan pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
}
