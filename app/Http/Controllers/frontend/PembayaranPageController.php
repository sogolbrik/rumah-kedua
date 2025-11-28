<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PembayaranPageController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function pembayaran($id)
    {
        $kamar = Kamar::with('detailKamar')->findOrFail($id);

        if ($kamar->status !== 'Tersedia') {
            return redirect()->route('booking')->with('error', 'Kamar tidak tersedia.');
        }

        return view('frontend.pembayaran.pembayaran', compact('kamar'));
    }

    public function pembayaranDetail($id)
    {
        $transaksi = Transaksi::with('kamar')->findOrFail($id);
        return view('frontend.pembayaran.pembayaran-detail', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamar,id',
            'durasi' => 'required|in:1,3,6',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $kamar = Kamar::findOrFail($request->id_kamar);
            $harga = (int) $kamar->harga;
            $durasi = (int) $request->durasi;
            $total_bayar = $harga * $durasi;

            // Pastikan kamar masih tersedia
            if ($kamar->status !== 'Tersedia') {
                throw new \Exception('Kamar sudah tidak tersedia.');
            }

            $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . now()->format('Ymd');
            $midtransOrderId = $this->midtransService->generateOrderId($kode);

            $transactionDetails = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId,
                    'gross_amount' => $total_bayar,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '081234567890',
                ],
                'item_details' => [
                    [
                        'id' => $kamar->id,
                        'price' => $total_bayar,
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
                throw new \Exception($midtransResponse['message'] ?? 'Gagal membuat transaksi Midtrans');
            }

            // 💡 Simpan transaksi dengan status PENDING — JANGAN UPDATE USER/KAMAR!
            $transaksi = Transaksi::create([
                'id_user' => $user->id,
                'id_kamar' => $kamar->id,
                'kode' => $kode,
                'tanggal_pembayaran' => now(),
                'tanggal_jatuhtempo' => now()->addMonths($durasi),
                'periode_pembayaran' => now()->format('Y-m'),
                'masuk_kamar' => now(),
                'durasi' => $durasi,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => 'midtrans',
                'status_pembayaran' => 'pending',
                'midtrans_order_id' => $midtransOrderId,
                'expired_at' => now()->addHours(24),
                'midtrans_response' => json_encode([
                    'snap_token' => $midtransResponse['snap_token'],
                    'created_at' => now()->toDateTimeString()
                ])
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'transaksi' => [
                    'id' => $transaksi->id,
                    'durasi' => $transaksi->durasi,
                    'total_bayar' => $transaksi->total_bayar,
                    'snap_token' => $midtransResponse['snap_token']
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus(Request $request)
    {
        $orderId = $request->orderId;
        $serverKey = config('midtrans.server_key');

        $response = Http::withBasicAuth($serverKey, '')
            ->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

        if (!$response->successful()) {
            return redirect()->route('user.penghuni')
                ->with('error', 'Gagal memeriksa status pembayaran.');
        }

        $model = $response->json();
        $trx = Transaksi::where('midtrans_order_id', $model['order_id'])->first();

        if (!$trx) {
            return redirect()->route('user.penghuni')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        // Simpan status lama
        $oldStatus = $trx->status_pembayaran;
        $newStatus = $oldStatus;

        // Mapping status
        switch ($model['transaction_status']) {
            case 'settlement':
                $newStatus = 'paid';
                break;
            case 'pending':
                $newStatus = 'pending';
                break;
            case 'expire':
                $newStatus = 'expired';
                break;
            case 'cancel':
                $newStatus = 'cancelled';
                break;
            case 'deny':
            case 'failure':
                $newStatus = 'failed';
                break;
            default:
                $newStatus = 'pending';
        }

        // Update status transaksi
        $trx->status_pembayaran = $newStatus;
        $trx->save();

        if ($oldStatus !== 'paid' && $newStatus === 'paid') {
            $this->updateUserAndKamar($trx->id_user, $trx->id_kamar, $trx->masuk_kamar);
        }

        return redirect()->route('user.penghuni')
            ->with('success', 'Status pembayaran diperbarui: ' . $this->getStatusLabel($newStatus));
    }

    private function updateUserAndKamar($userId, $kamarId, $tanggalMasuk)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update([
                'id_kamar' => $kamarId,
                'tanggal_masuk' => $tanggalMasuk,
                'status_penghuni' => 'aktif',
                'role' => 'penghuni',
            ]);
        }

        Kamar::where('id', $kamarId)->update(['status' => 'Terisi']);
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            'challenge' => 'Dalam Tantangan'
        ];

        return $labels[$status] ?? $status;
    }
}