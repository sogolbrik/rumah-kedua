<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
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

        return view('frontend.user.pembayaran-penghuni', ['user' => $user]);
    }

    /**
     * Ambil data tagihan jatuh tempo terbaru (untuk ditampilkan di halaman)
     */
    public function getTagihanData()
    {
        $user = Auth::user();

        // Cari transaksi dengan status 'pending' yang jatuh tempo <= hari ini
        $transaksi = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->where('tanggal_jatuhtempo', '<=', now())
            ->orderBy('tanggal_jatuhtempo', 'desc')
            ->first();

        if (!$transaksi) {
            // Opsional: Buat transaksi otomatis untuk periode berikutnya
            // jika belum ada transaksi menunggak
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tagihan jatuh tempo.'
            ]);
        }

        return response()->json([
            'success' => true,
            'transaksi' => [
                'id' => $transaksi->id,
                'kode' => $transaksi->kode,
                'total_bayar' => (int) $transaksi->total_bayar,
                'tanggal_jatuhtempo' => $transaksi->tanggal_jatuhtempo->toDateString(),
                'periode_mulai' => Carbon::parse($transaksi->masuk_kamar)->format('M Y'),
                'periode_akhir' => Carbon::parse($transaksi->masuk_kamar)->addMonths($transaksi->durasi - 1)->format('M Y'),
                'kamar_kode' => $transaksi->kamar->kode_kamar ?? '–',
            ]
        ]);
    }

    /**
     * Siapkan pembayaran Midtrans untuk tagihan yang ada
     */
    public function bayarTagihan(Request $request)
    {
        $user = Auth::user();

        $transaksi = Transaksi::with('kamar')
            ->where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->where('tanggal_jatuhtempo', '<=', now())
            ->orderBy('tanggal_jatuhtempo', 'desc')
            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan atau sudah dibayar.'
            ], 404);
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
            return response()->json([
                'success' => true,
                'snap_token' => $midtransData['snap_token']
            ]);
        }

        // Jika token expired atau tidak ada, buat baru
        try {
            $transactionDetails = [
                'transaction_details' => [
                    'order_id' => $transaksi->midtrans_order_id,
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
                        'name' => "Pembayaran Tagihan Kamar {$transaksi->kamar->kode_kamar} - Periode " . Carbon::parse($transaksi->masuk_kamar)->format('M Y'),
                        'category' => 'Tagihan Bulanan'
                    ]
                ],
                'expiry' => [
                    'start_time' => now()->format('Y-m-d H:i:s O'),
                    'unit' => 'hour',
                    'duration' => 24
                ]
            ];

            $midtransResponse = $this->midtransService->createTransaction($transactionDetails);

            if (!$midtransResponse['success']) {
                throw new \Exception($midtransResponse['message'] ?? 'Gagal membuat token Midtrans');
            }

            // Simpan snap_token & expired_at
            $transaksi->midtrans_response = json_encode([
                'snap_token' => $midtransResponse['snap_token'],
                'expired_at' => now()->addHours(24)->toDateTimeString()
            ]);
            $transaksi->save();

            return response()->json([
                'success' => true,
                'snap_token' => $midtransResponse['snap_token']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyiapkan pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
}
