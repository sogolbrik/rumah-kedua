<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        $this->setupConfig();
    }

    private function setupConfig()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function createTransaction(array $transactionData)
    {
        $this->validateTransactionData($transactionData);
        $snapToken = Snap::getSnapToken($transactionData);

        return [
            'success' => true,
            'snap_token' => $snapToken,
            'redirect_url' => null
        ];
    }

    private function validateTransactionData(array $transactionData)
    {
        if (
            !isset($transactionData['transaction_details']['gross_amount']) ||
            $transactionData['transaction_details']['gross_amount'] <= 0
        ) {
            throw new \Exception('Gross amount harus lebih dari 0');
        }

        if (empty($transactionData['transaction_details']['order_id'])) {
            throw new \Exception('Order ID tidak boleh kosong');
        }

        if (empty($transactionData['customer_details']['first_name'])) {
            throw new \Exception('Customer name is required');
        }
    }

    public function generateOrderId($kode)
    {
        return 'TRX-' . $kode . '-' . time();
    }

    public function checkTransactionStatus($orderId)
    {
        $status = Transaction::status($orderId);

        return [
            'success' => true,
            'status' => $status
        ];
    }

    public function cancelTransaction($orderId)
    {
        $cancel = Transaction::cancel($orderId);

        return [
            'success' => true,
            'data' => $cancel
        ];
    }
}