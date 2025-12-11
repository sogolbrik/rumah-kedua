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

        if ($request->has('verify_payment')) {
            $this->verifyMidtransPayment($user);
            // Setelah verifikasi, redirect ulang tanpa query agar tidak loop
            return redirect()->route('dashboard-penghuni');
        }

        return view('frontend.user.pembayaran-penghuni', [
            'user' => $user,
            'dataTransaksi' => $dataTransaksi,
            'isOverdue' => $isOverdue,
            'message' => $message,
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
            'midtrans_response' => null, // <-- Tetap null dulu
            'expired_at' => now()->addDay()->toDateTimeString(), // Expired 1 hari dari sekarang
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
                'start_time' => now()->format('Y-m-d H:i:s O'), // Gunakan Carbon untuk konsistensi
                'unit' => 'hour',
                'duration' => 24
            ]
        ];

        // Panggil service untuk membuat token
        $midtransResponse = $this->midtransService->createTransaction($transactionDetails);

        if (!$midtransResponse['success']) {
            // Jika pembuatan token gagal, hapus transaksi yang baru dibuat
            $transaksi->delete();
            return back()->withErrors(['durasi' => 'Gagal membuat token pembayaran. Silakan coba lagi.']);
        }

        // Simpan response ke database
        $transaksi->midtrans_response = json_encode([
            'snap_token' => $midtransResponse['snap_token'],
            'redirect_url' => $midtransResponse['redirect_url'] ?? null,
            'expired_at' => $midtransResponse['expired_at'] ?? null,
            'created_at' => now()->toDateTimeString()
        ]);

        // Simpan perubahan ke database
        $transaksi->save(); // <-- Kita gunakan save() untuk memperbarui record yang sudah ada

        // Kembali ke halaman utama dengan pesan sukses
        return back()->with('success', 'Transaksi baru berhasil dibuat. Silakan klik tombol "Lanjutkan Pembayaran" untuk menyelesaikan pembayaran.');
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

        // Jika belum paid, cek apakah perlu generate token baru
        $midtransData = $transaksi->midtrans_response;
        $tokenExistsAndIsValid = false;

        if (is_array($midtransData) && isset($midtransData['snap_token']) && isset($midtransData['expired_at'])) {
            $tokenExpiredAt = Carbon::parse($midtransData['expired_at']);
            $tokenExistsAndIsValid = now()->lt($tokenExpiredAt);
        }

        // Jika token tidak valid/expired → buat baru
        if (!$tokenExistsAndIsValid) {
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
                            'name' => "Pembayaran Sewa Kamar {$transaksi->kamar->kode_kamar} ({$transaksi->durasi} Bulan)",
                            'category' => 'Sewa Kost'
                        ]
                    ],
                    'expiry' => [
                        'start_time' => now()->format('Y-m-d H:i:s O'),
                        'unit' => 'day',
                        'duration' => 1
                    ]
                ];

                $midtransResponse = $this->midtransService->createTransaction($transactionDetails);

                if (!$midtransResponse['success']) {
                    throw new \Exception($midtransResponse['message'] ?? 'Gagal membuat token Midtrans');
                }

                $transaksi->midtrans_response = [
                    'snap_token' => $midtransResponse['snap_token'],
                    'expired_at' => now()->addDay()->toDateTimeString(),
                    'created_at' => now()->toDateTimeString(),
                ];
                $transaksi->save();

                return response()->json([
                    'success' => true,
                    'snap_token' => $midtransResponse['snap_token'],
                    'transaksi_id' => $transaksi->id
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyiapkan pembayaran: ' . $e->getMessage()
                ], 500);
            }
        }

        // Token valid dan transaksi belum paid → kembalikan token lama
        return response()->json([
            'success' => true,
            'snap_token' => $midtransData['snap_token'],
            'transaksi_id' => $transaksi->id
        ]);
    }

    private function verifyMidtransPayment($user)
    {
        $transaksi = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();

        if (!$transaksi)
            return;

        $orderId = $transaksi->midtrans_order_id;
        $serverKey = config('midtrans.server_key');

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->timeout(15)
                ->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

            if ($response->successful()) {
                $model = $response->json();
                if (in_array($model['transaction_status'] ?? null, ['settlement', 'capture'])) {
                    $transaksi->status_pembayaran = 'paid';
                    $transaksi->midtrans_transaction_id = $model['transaction_id'] ?? null;
                    $transaksi->midtrans_payment_type = $model['payment_type'] ?? null;
                    $transaksi->save();

                    session()->flash('success', 'Pembayaran berhasil! Status transaksi telah diperbarui.');
                    return;
                }
            }
        } catch (\Exception $e) {
            // diam saja, jangan tampilkan error
        }

        // Jika gagal verifikasi, cukup beri info
        session()->flash('info', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.');
    }
}
