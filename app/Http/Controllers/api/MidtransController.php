<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MidtransController extends Controller
{
    public function handleNotification(Request $request)
    {
        $notification = $request->all();

        $orderId = $notification['order_id'] ?? null;
        $transactionStatus = $notification['transaction_status'] ?? null;
        $fraudStatus = $notification['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order ID required'
            ], 400);
        }

        $transaksi = Transaksi::where('midtrans_order_id', $orderId)->first();

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found for order_id: ' . $orderId
            ], 404);
        }

        $this->updateTransactionStatus($transaksi, $notification, $transactionStatus, $fraudStatus);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification processed successfully',
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus
        ]);
    }

    private function updateTransactionStatus($transaksi, $notification, $transactionStatus, $fraudStatus)
    {
        DB::beginTransaction();

        switch ($transactionStatus) {
            case 'capture':
                // Untuk status capture, langsung proses sebagai pembayaran berhasil
                // karena biasanya capture sudah berarti pembayaran diterima
                if ($fraudStatus == 'challenge') {
                    $transaksi->update([
                        'status_pembayaran'       => 'challenge',
                        'midtrans_payment_type'   => $notification['payment_type'] ?? null,
                        'midtrans_transaction_id' => $notification['transaction_id'] ?? null,
                        'midtrans_response'       => $notification
                    ]);
                } else {
                    // Jika fraud_status bukan challenge, anggap sebagai pembayaran berhasil
                    $this->processSuccessfulPayment($transaksi, $notification);
                }
                break;

            case 'settlement':
                $this->processSuccessfulPayment($transaksi, $notification);
                break;

            case 'pending':
                $transaksi->update([
                    'status_pembayaran'     => 'pending',
                    'midtrans_payment_type' => $notification['payment_type'] ?? null,
                    'midtrans_response'     => $notification
                ]);
                break;

            case 'deny':
                $transaksi->update([
                    'status_pembayaran' => 'failed',
                    'midtrans_response' => $notification
                ]);
                break;

            case 'cancel':
            case 'expire':
                $transaksi->update([
                    'status_pembayaran' => $transactionStatus == 'cancel' ? 'cancelled' : 'expired',
                    'midtrans_response' => $notification
                ]);
                break;
        }

        DB::commit();
    }

    private function processSuccessfulPayment($transaksi, $notification)
    {
        // Cek apakah transaksi sudah berstatus paid untuk menghindari duplikasi
        if ($transaksi->status_pembayaran === 'paid') {
            return;
        }

        // Update transaksi
        $transaksi->update([
            'status_pembayaran'       => 'paid',
            'midtrans_payment_type'   => $notification['payment_type'] ?? null,
            'midtrans_transaction_id' => $notification['transaction_id'] ?? null,
            'midtrans_response'       => $notification,
            'updated_at'              => now()
        ]);

        // Update user dan kamar
        $this->updateUserAndKamar($transaksi->id_user, $transaksi->id_kamar, $transaksi->masuk_kamar);
    }

    private function updateUserAndKamar($userId, $kamarId, $tanggalMasuk)
    {
        // Update user
        $user = User::find($userId);
        if ($user) {
            $user->update([
                'id_kamar'        => $kamarId,
                'tanggal_masuk'   => $tanggalMasuk,
                'status_penghuni' => 'aktif',
                'role'            => 'penghuni',
                'updated_at'      => now()
            ]);
        }

        // Update status kamar
        $kamar = Kamar::find($kamarId);
        if ($kamar) {
            $kamar->update([
                'status' => 'Terisi',
                'updated_at' => now()
            ]);
        }
    }

    public function checkPaymentStatus($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        return response()->json([
            'status_pembayaran' => $transaksi->status_pembayaran,
            'midtrans_order_id' => $transaksi->midtrans_order_id,
            'midtrans_payment_type' => $transaksi->midtrans_payment_type,
            'midtrans_transaction_id' => $transaksi->midtrans_transaction_id,
            'expired_at' => $transaksi->expired_at
        ]);
    }
}
