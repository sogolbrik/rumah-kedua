<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kamar;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

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
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->kamar) {
            return redirect()->route('dashboard-penghuni')->with('error', 'Anda belum memiliki kamar.');
        }

        $transaksi = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_jatuhtempo', 'desc')
            ->first();

        $dataTransaksi = null;
        $isOverdue = false;

        if ($transaksi) {
            $isOverdue = $transaksi->tanggal_jatuhtempo < now()->toDateString();

            if ($isOverdue) {
                $dataTransaksi = [
                    'id' => $transaksi->id,
                    'kode' => $transaksi->kode,
                    'total_bayar' => (int) $transaksi->total_bayar,
                    'tanggal_jatuhtempo' => $transaksi->tanggal_jatuhtempo->toDateString(),
                    'periode_mulai' => Carbon::parse($transaksi->masuk_kamar)->format('M Y'),
                    'periode_akhir' => Carbon::parse($transaksi->masuk_kamar)->addMonths($transaksi->durasi - 1)->format('M Y'),
                    'kamar_kode' => $transaksi->kamar->kode_kamar ?? '-',
                ];
            }
        }

        $transaksiPending = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();

        if ($transaksiPending) {
            $message = null;
        } else {
            $message = !$transaksi ? 'Tidak ada transaksi ditemukan.' : (!$isOverdue ? 'Belum ada tagihan yang jatuh tempo.' : null);
        }

        if ($request->has('verify_payment')) {
            $this->verifyMidtransPayment($user);
            return redirect()->route('dashboard-penghuni');
        }

        return view('frontend.user.pembayaran-penghuni', [
            'user'             => $user,
            'dataTransaksi'    => $dataTransaksi,
            'isOverdue'        => $isOverdue,
            'message'          => $message,
            'transaksiPending' => $transaksiPending,
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

        $kamar = $user->kamar;
        if (!$kamar) {
            return back()->withErrors(['durasi' => 'Data kamar tidak ditemukan.']);
        }

        $transaksiPending = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();

        if ($transaksiPending) {
            return back()->withErrors(['durasi' => 'Anda sudah memiliki transaksi yang menunggu pembayaran. Silakan selesaikan terlebih dahulu.']);
        }

        $totalBayar = $kamar->harga * $durasi;
        $tanggalMasuk = now()->toDateString();
        $tanggalJatuhTempo = Carbon::parse($tanggalMasuk)->addMonths($durasi)->subDays(1)->toDateString();
        $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
        $midtransOrderId = $this->midtransService->generateOrderId($kode);

        $transaksi = Transaksi::create([
            'id_user' => $user->id,
            'id_kamar' => $kamar->id,
            'kode' => $kode,
            'tanggal_pembayaran' => now(),
            'tanggal_jatuhtempo' => $tanggalJatuhTempo,
            'masuk_kamar' => $tanggalMasuk,
            'durasi' => $durasi,
            'total_bayar' => $totalBayar,
            'metode_pembayaran' => 'midtrans',
            'status_pembayaran' => 'pending',
            'midtrans_order_id' => $midtransOrderId,
            'midtrans_transaction_id' => null,
            'midtrans_payment_type' => null,
            'midtrans_response' => null,
        ]);

        // --- Bagian Pembuatan Token Midtrans ---
        $transactionDetails = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => $totalBayar,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '081234567890',
            ],
            'item_details' => [
                [
                    'id' => $transaksi->id,
                    'price' => $totalBayar,
                    'quantity' => 1,
                    'name' => 'Pembayaran Kos - ' . $kamar->kode_kamar . ' - ' . $request->durasi . ' Bulan',
                    'category' => 'Kost'
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
            $transaksi->delete();
            return back()->withErrors(['durasi' => 'Gagal membuat token pembayaran. Silakan coba lagi.']);
        }

        $transaksi->midtrans_response = json_encode([
            'snap_token' => $midtransResponse['snap_token'],
            'expired_at' => now()->addDay()->toDateTimeString(),
            'created_at' => now()->toDateTimeString()
        ]);

        $transaksi->save();

        return back()->with('success', 'Transaksi baru berhasil dibuat. Silakan klik tombol "Bayar Sekarang" untuk menyelesaikan pembayaran.');
    }

    /**
     * Siapkan pembayaran Midtrans untuk transaksi pending user (via JSON API)
     */
    public function PembayaranMidtrans(Request $request)
    {
        $user = Auth::user();

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

        if ($transaksi->total_bayar <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Total tagihan tidak valid.'
            ], 400);
        }

        $midtransData = $transaksi->midtrans_response;
        $tokenExistsAndIsValid = false;

        if (is_array($midtransData) && isset($midtransData['snap_token']) && isset($midtransData['expired_at'])) {
            $tokenExpiredAt = Carbon::parse($midtransData['expired_at']);
            $tokenExistsAndIsValid = now()->lt($tokenExpiredAt);
        }

        // Jika token tidak valid/expired
        if (!$tokenExistsAndIsValid) {
            return response()->json([
                'success' => false,
                'message' => 'Token pembayaran sudah kadaluarsa. Silahkan klik "Buat Ulang" untuk transaksi ulang.'
            ], 400);
        }

        // Token valid dan transaksi belum paid
        return response()->json([
            'success' => true,
            'snap_token' => $midtransData['snap_token'],
            'transaksi_id' => $transaksi->id
        ]);
    }

    private function verifyMidtransPayment($user, $maxRetries = 3)
    {
        $transaksi = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();

        if (!$transaksi)
            return false;

        $orderId = $transaksi->midtrans_order_id;
        $serverKey = config('midtrans.server_key');

        for ($i = 0; $i < $maxRetries; $i++) {
            try {
                $response = Http::withBasicAuth($serverKey, '')
                    ->timeout(15)
                    ->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

                if ($response->successful()) {
                    $model = $response->json();
                    if (in_array($model['transaction_status'] ?? null, ['settlement', 'capture'])) {
                        $transaksi->update([
                            'status_pembayaran' => 'paid',
                            'midtrans_transaction_id' => $model['transaction_id'] ?? null,
                            'midtrans_payment_type' => $model['payment_type'] ?? null,
                        ]);

                        if (!$user->kamar) {
                            $user->update([
                                'id_kamar' => $transaksi->id_kamar,
                                'tanggal_masuk' => $transaksi->masuk_kamar,
                                'role' => 'penghuni',
                            ]);
                            Kamar::where('id', $transaksi->id_kamar)->update(['status' => 'Terisi']);
                        }

                        return true;
                    }
                }

                if ($i < $maxRetries - 1) {
                    sleep(2);
                }

            } catch (\Exception $e) {
                // Log::warning("Midtrans verify attempt {$i} failed: " . $e->getMessage());
                if ($i < $maxRetries - 1) {
                    sleep(2);
                }
            }
        }

        return false;
    }

    public function buatUlangTransaksi(Request $request, $idKamar)
    {
        $user = Auth::user();
        $kamar = Kamar::findOrFail($idKamar);

        if ($kamar->status !== 'Terisi') {
            return redirect()->route('penghuni.pembayaran')->with('error', 'Ini bukan kamar nda.');
        }

        $transaksiLama = Transaksi::where('id_user', $user->id)
            ->where('id_kamar', $kamar->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();
        $transaksiLama->update([
            'status_pembayaran' => 'expired',
        ]);

        if (!$transaksiLama) {
            return redirect()->route('penghuni.pembayaran')->with('error', 'Tidak ada transaksi yang bisa diulang.');
        }

        // Validasi expired
        $midtransData = $transaksiLama->midtrans_response;
        if (is_string($midtransData)) {
            $midtransData = json_decode($midtransData, true);
        }

        $isExpired = false;
        if (isset($midtransData['expired_at'])) {
            $expiredAt = Carbon::parse($midtransData['expired_at']);
            $isExpired = now()->gt($expiredAt);
        }

        if (!$isExpired) {
            return redirect()->route('penghuni.pembayaran')->with('error', 'Transaksi masih berlaku. Tidak perlu dibuat ulang.');
        }

        $durasi = (int) $transaksiLama->durasi;
        $totalBayar = $kamar->harga * $durasi;
        $tanggalMasuk = $transaksiLama->masuk_kamar;

        try {
            $tanggalMasukCarbon = Carbon::parse($tanggalMasuk);
        } catch (\Exception $e) {
            $tanggalMasukCarbon = now();
        }

        $tanggalJatuhTempo = $tanggalMasukCarbon->copy()
            ->addMonths($durasi)
            ->subDays(1)
            ->toDateString();

        $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
        $midtransOrderId = $this->midtransService->generateOrderId($kode);

        $transaksiBaru = Transaksi::create([
            'id_user' => $user->id,
            'id_kamar' => $kamar->id,
            'kode' => $kode,
            'tanggal_pembayaran' => now(),
            'tanggal_jatuhtempo' => $tanggalJatuhTempo,
            'masuk_kamar' => $tanggalMasuk,
            'durasi' => $durasi,
            'total_bayar' => $totalBayar,
            'metode_pembayaran' => 'midtrans',
            'status_pembayaran' => 'pending',
            'midtrans_order_id' => $midtransOrderId,
            'midtrans_transaction_id' => null,
            'midtrans_payment_type' => null,
            'midtrans_response' => null,
        ]);

        $transactionDetails = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => $totalBayar,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '081234567890',
            ],
            'item_details' => [
                [
                    'id' => $kamar->id,
                    'price' => $totalBayar,
                    'quantity' => 1,
                    'name' => "Pembayaran Kos {$kamar->kode_kamar} - {$durasi} Bulan",
                    'category' => 'Kost'
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
            $transaksiBaru->delete();
            return back()->withErrors(['system' => 'Gagal membuat token pembayaran. Silakan coba lagi.']);
        }

        $transaksiBaru->midtrans_response = json_encode([
            'snap_token' => $midtransResponse['snap_token'],
            'created_at' => now()->toDateTimeString(),
            'expired_at' => now()->addDay()->toDateTimeString(),
        ]);
        $transaksiBaru->save();

        return redirect()->route('penghuni.pembayaran', $kamar)->with('success', 'Transaksi baru berhasil dibuat. Silakan lanjutkan pembayaran.');
    }
}
