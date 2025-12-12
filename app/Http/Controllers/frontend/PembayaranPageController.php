<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kamar;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PembayaranPageController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Tampilkan halaman pembayaran untuk user baru (belum punya kamar)
     */
    public function index(Request $request, $id)
    {
        $user = Auth::user();

        // Ambil kamar yang dipilih
        $kamar = Kamar::with('detailKamar')->findOrFail($id);

        if ($kamar->status !== 'Tersedia') {
            return redirect()->route('dashboard-penghuni')
                ->with('error', 'Kamar tidak tersedia untuk dipesan.');
        }

        // Cari transaksi 'pending' untuk kamar ini oleh user ini (jika ada)
        $transaksiPending = Transaksi::where('id_user', $user->id)
            ->where('id_kamar', $kamar->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();

        if ($request->has('verify_payment')) {
            $this->verifyMidtransPayment(Auth::user());
            return redirect()->route('dashboard-penghuni'); // atau ke halaman lain
        }
        
        return view('frontend.pembayaran.pembayaran-user', [
            'user' => $user,
            'kamar' => $kamar,
            'transaksiPending' => $transaksiPending,
        ]);
    }

    /**
     * Buat transaksi baru untuk user baru (booking kamar pertama kali)
     */
    public function buatTransaksiBaru(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'durasi' => 'required|in:1,3,6',
            'id_kamar' => 'required|exists:kamars,id'
        ]);

        $durasi = (int) $request->durasi;
        $kamar = Kamar::findOrFail($request->id_kamar);

        if ($kamar->status !== 'Tersedia') {
            return back()->withErrors(['durasi' => 'Kamar sudah tidak tersedia.']);
        }

        // Cek apakah sudah ada transaksi pending untuk kamar ini
        $transaksiPending = Transaksi::where('id_user', $user->id)
            ->where('id_kamar', $kamar->id)
            ->where('status_pembayaran', 'pending')
            ->latest()
            ->first();

        if ($transaksiPending) {
            return back()->withErrors(['durasi' => 'Anda sudah memiliki transaksi menunggu pembayaran untuk kamar ini.']);
        }

        $totalBayar = $kamar->harga * $durasi;
        $tanggalMasuk = now()->toDateString();
        $tanggalJatuhTempo = Carbon::parse($tanggalMasuk)->addMonths($durasi)->subDays(1)->toDateString();
        $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
        $midtransOrderId = $this->midtransService->generateOrderId($kode);

        // Buat transaksi
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
            'expired_at' => now()->addDay()->toDateTimeString(),
        ]);

        // Buat token Midtrans
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
            $transaksi->delete();
            return back()->withErrors(['durasi' => 'Gagal membuat token pembayaran. Silakan coba lagi.']);
        }

        $transaksi->midtrans_response = json_encode([
            'snap_token' => $midtransResponse['snap_token'],
            'created_at' => now()->toDateTimeString(),
            'expired_at' => now()->addDay()->toDateTimeString(),
        ]);
        $transaksi->save();

        return back()->with('success', 'Transaksi berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    /**
     * Siapkan pembayaran Midtrans (untuk transaksi pending)
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
                            'id' => $transaksi->id_kamar,
                            'price' => (int) $transaksi->total_bayar,
                            'quantity' => 1,
                            'name' => "Pembayaran Kos {$transaksi->kamar->kode_kamar} ({$transaksi->durasi} Bulan)",
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
                    throw new \Exception($midtransResponse['message'] ?? 'Gagal membuat token Midtrans');
                }

                $transaksi->midtrans_response = [
                    'snap_token' => $midtransResponse['snap_token'],
                    'expired_at' => now()->addHours(24)->toDateTimeString(),
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

                    $user->update([
                        'id_kamar'      => $transaksi->id_kamar,
                        'tanggal_masuk' => $transaksi->masuk_kamar,
                        'role'          => 'penghuni',
                    ]);

                    Kamar::where('id', $transaksi->id_kamar)->update(['status' => 'Terisi']);

                    session()->flash('success', 'Pembayaran berhasil! Anda sekarang resmi menjadi penghuni.');
                    return;
                }
            }
        } catch (\Exception $e) {
            // diam saja
        }

        session()->flash('info', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.');
    }
}