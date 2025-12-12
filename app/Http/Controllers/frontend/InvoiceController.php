<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //Invoice Penghuni
    public function invoicePembayaran($id)
    {
        $transaksi = Transaksi::with('kamar', 'user')->findOrFail($id)->first();
        return view('frontend.pembayaran.invoice-pembayaran', [
            'transaksi' => $transaksi
        ]);
    }
}
