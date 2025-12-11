<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //Invoice Penghuni
    public function invoicePenghuni($id)
    {
        $transaksi = Transaksi::with('kamar')->findOrFail($id)->first();
        return view('frontend.user.invoice-pembayaran', [
            'transaksi' => $transaksi
        ]);
    }
}
