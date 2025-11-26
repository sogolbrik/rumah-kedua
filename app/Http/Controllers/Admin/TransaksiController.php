<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Kamar;
use App\Http\Requests\StoreTransaksiRequest;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $transaksis = Transaksi::with(['user', 'kamar'])
            ->latest()
            ->paginate(10);

        return view('admin.transaksi.data', compact('transaksis'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $kamars = Kamar::where('status', 'Tersedia')->get();

        return view('admin.transaksi.form', compact('users', 'kamars'));
    }

    public function store(StoreTransaksiRequest $request)
    {
        DB::beginTransaction();

        $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
        $tanggalJatuhTempo = $this->calculateDueDate($request->tanggal_pembayaran, $request->durasi);
        $total_bayar = (int) str_replace('.', '', $request->total_bayar);

        if ($total_bayar <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Total bayar harus lebih dari 0');
        }

        $transaksiData = [
            'id_user' => $request->id_user,
            'id_kamar' => $request->id_kamar,
            'kode' => $kode,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'tanggal_jatuhtempo' => $tanggalJatuhTempo,
            'periode_pembayaran' => $request->periode_pembayaran,
            'masuk_kamar' => $request->masuk_kamar,
            'durasi' => $request->durasi,
            'total_bayar' => $total_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'pending'
        ];

        if ($request->metode_pembayaran === 'cash') {
            $transaksiData['status_pembayaran'] = 'paid';
            $transaksi = Transaksi::create($transaksiData);

            $this->updateUserAndKamar($transaksi->id_user, $transaksi->id_kamar, $transaksi->masuk_kamar);

            DB::commit();

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi cash berhasil dibuat dan sudah dibayar.');
        }

        $midtransOrderId = $this->midtransService->generateOrderId($kode);
        $transaksiData['midtrans_order_id'] = $midtransOrderId;
        $transaksiData['expired_at'] = Carbon::now()->addHours(24);

        $user = User::find($request->id_user);
        $kamar = Kamar::find($request->id_kamar);

        if (!$user) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'User tidak ditemukan');
        }

        if (!$kamar) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kamar tidak ditemukan');
        }

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
                    'name' => 'Pembayaran Kos - ' . $kamar->nama_kamar . ' - ' . $request->durasi,
                    'category' => 'Kost'
                ]
            ],
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s O'),
                'unit' => 'hour',
                'duration' => 24
            ]
        ];

        $midtransResponse = $this->midtransService->createTransaction($transactionDetails);

        if (!$midtransResponse['success']) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat transaksi Midtrans: ' . $midtransResponse['message']);
        }

        $transaksiData['midtrans_response'] = json_encode([
            'snap_token' => $midtransResponse['snap_token'],
            'redirect_url' => $midtransResponse['redirect_url'] ?? null,
            'created_at' => now()->toDateTimeString()
        ]);

        $transaksi = Transaksi::create($transaksiData);

        DB::commit();

        return redirect()->route('transaksi.payment', $transaksi->id)
            ->with('success', 'Transaksi berhasil dibuat. Silakan selesaikan pembayaran.');
    }

    public function payment($id)
    {
        $transaksi = Transaksi::with(['user', 'kamar'])->findOrFail($id);

        if ($transaksi->metode_pembayaran === 'midtrans' && !isset($transaksi->midtrans_response['snap_token'])) {
            return redirect()->route('transaksi.index')
                ->with('error', 'Token pembayaran tidak tersedia. Silakan buat transaksi ulang.');
        }

        return view('admin.transaksi.pembayaran', compact('transaksi'));
    }


    public function checkStatus(Request $request)
    {
        $orderId = $request->orderId;
        $serverKey = config('midtrans.server_key');

        $response = Http::withBasicAuth($serverKey, '')
            ->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

        $model = $response->json();

        // Find DB record
        $trx = Transaksi::where("midtrans_order_id", $model["order_id"])->first();

        if (!$trx) {
            return response()->json(["error" => "Transaction not found"], 404);
        }

        if ($model["transaction_status"] === "pending") {
            $trx->status_pembayaran = "pending";
        } elseif ($model["transaction_status"] === "settlement") {
            $trx->status_pembayaran = "paid";
        }

        $this->updateUserAndKamar($trx->id_user, $trx->id_kamar, $trx->masuk_kamar);

        $trx->save();

        return redirect()->route('transaksi.index')
            ->with('success', 'Status transaksi berhasil diperbarui menjadi ' . $this->getStatusLabel($trx->status_pembayaran) . '.');
    }

    public function cancel($id)
    {
        DB::beginTransaction();

        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status_pembayaran === 'paid') {
            return redirect()->back()
                ->with('error', 'Tidak dapat membatalkan transaksi yang sudah dibayar.');
        }

        if ($transaksi->metode_pembayaran === 'midtrans' && $transaksi->midtrans_order_id) {
            $this->midtransService->cancelTransaction($transaksi->midtrans_order_id);
        }

        $transaksi->update([
            'status_pembayaran' => 'cancelled'
        ]);

        DB::commit();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $transaksi = Transaksi::findOrFail($id);

        if (in_array($transaksi->status_pembayaran, ['paid', 'pending'])) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus transaksi dengan status ' . $transaksi->status_pembayaran);
        }

        $transaksi->delete();

        DB::commit();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    private function calculateDueDate($tanggalPembayaran, $durasi)
    {
        $tanggal = Carbon::parse($tanggalPembayaran);

        switch ($durasi) {
            case '1 bulan':
                return $tanggal->addMonth();
            case '3 bulan':
                return $tanggal->addMonths(3);
            case '6 bulan':
                return $tanggal->addMonths(6);
            case '1 tahun':
                return $tanggal->addYear();
            default:
                return $tanggal->addMonth();
        }
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

        return true;
    }
}
