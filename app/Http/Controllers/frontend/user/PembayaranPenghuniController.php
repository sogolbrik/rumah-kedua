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

        // Cari transaksi 'pending' yang sudah dibuat sebelumnya untuk user ini (jika ada)
        $transaksiPending = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->latest() // Ambil yang terbaru
            ->first();

        // --- LOGIKA ---
        // Jika ada transaksi pending, kita anggap user sudah dalam proses pembayaran,
        // jadi kita abaikan pengecekan overdue dan tampilkan tombol lanjutkan pembayaran.
        // Jika tidak ada transaksi pending, baru gunakan logika isOverdue.
        if ($transaksiPending) {
            // Set message menjadi null karena kita tidak ingin menampilkan pesan "Belum ada tagihan..."
            $message = null;
        } else {
            // Gunakan message default dari logika isOverdue
            $message = !$transaksi ? 'Tidak ada transaksi ditemukan.' : (!$isOverdue ? 'Belum ada tagihan yang jatuh tempo.' : null);
        }

        return view('frontend.user.pembayaran-penghuni', [
            'user' => $user,
            'dataTransaksi' => $dataTransaksi,
            'isOverdue' => $isOverdue,
            'message' => $message,
            'transaksiPending' => $transaksiPending, // Kirim transaksi pending ke view
        ]);
    }

    /**
     * Buat transaksi baru berdasarkan durasi pilihan user (dari form biasa)
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
            return back()->withErrors(['durasi' => 'Data kamar tidak ditemukan.']);
        }

        // Cek apakah sudah ada transaksi 'pending' yang belum dibayar
        $transaksiPending = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->latest() // Ambil yang terbaru
            ->first();

        if ($transaksiPending) {
            // Jika sudah ada transaksi pending, kembalikan ke halaman dengan error
            return back()->withErrors(['durasi' => 'Anda sudah memiliki transaksi yang menunggu pembayaran. Silakan selesaikan terlebih dahulu.']);
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
        Transaksi::create([
            'id_user' => $user->id,
            'id_kamar' => $kamar->id,
            'kode' => $kode,
            'tanggal_pembayaran' => now(), // Belum dibayar
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
            'expired_at' => now()->addDay()->toDateTimeString(), // Expired 1 hari dari sekarang
        ]);

        // Kembali ke halaman utama dengan pesan sukses
        return back()->with('success', 'Transaksi baru berhasil dibuat. Silakan klik tombol "Lanjutkan Pembayaran" untuk menyelesaikan pembayaran.');
    }

    /**
     * Siapkan pembayaran Midtrans untuk transaksi pending user (via JSON API)
     */
    public function siapkanPembayaranMidtrans(Request $request)
    {
        $user = Auth::user();

        // Cari transaksi pending milik user (ambil yang terbaru)
        $transaksi = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ditemukan transaksi yang menunggu pembayaran.'
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

        // Cek apakah token masih valid berdasarkan expired_at di database
        $tokenExpired = now()->gte($transaksi->expired_at);

        // Jika token Midtrans di database sudah expired, buat baru
        if ($tokenExpired) {
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
                        'unit' => 'day', // Ganti unit ke 'day'
                        'duration' => 1   // Durasi 1 hari
                    ]
                ];

                Log::info('Preparing Midtrans Transaction for ID: ' . $transaksi->id, $transactionDetails);

                $midtransResponse = $this->midtransService->createTransaction($transactionDetails);

                if (!$midtransResponse['success']) {
                    throw new \Exception($midtransResponse['message'] ?? 'Gagal membuat token Midtrans');
                }

                // Simpan snap_token & perbarui expired_at ke database
                $transaksi->midtrans_response = json_encode([
                    'snap_token' => $midtransResponse['snap_token'],
                    'expired_at' => now()->addDay()->toDateTimeString(), // Perbarui expired 1 hari dari sekarang
                ]);
                $transaksi->save();

                return response()->json([
                    'success' => true,
                    'snap_token' => $midtransResponse['snap_token'],
                    'transaksi_id' => $transaksi->id
                ]);

            } catch (\Exception $e) {
                Log::error('Midtrans Payment Error for Transaction ID: ' . $transaksi->id, ['message' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyiapkan pembayaran: ' . $e->getMessage()
                ], 500);
            }
        } else {
            // Jika token di database masih valid, kembalikan token yang lama
            // Pastikan snap_token ada di dalam data
            if (isset($midtransData['snap_token'])) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $midtransData['snap_token'],
                    'transaksi_id' => $transaksi->id
                ]);
            } else {
                // Jika tidak ada snap_token, buat baru
                // (ini bisa terjadi jika expired_at di db di-set manual tapi snap_token tidak disimpan)
                return response()->json([
                    'success' => false,
                    'message' => 'Token pembayaran tidak ditemukan. Silakan coba lagi.'
                ], 500);
            }
        }
    }
}
