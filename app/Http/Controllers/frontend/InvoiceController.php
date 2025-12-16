<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //Invoice Penghuni
    public function invoicePembayaran($id)
    {
        $transaksi = Transaksi::with('kamar', 'user')->findOrFail($id);
        return view('frontend.pembayaran.invoice-pembayaran', [
            'transaksi' => $transaksi
        ]);
    }

    public function exportInvoicePdf($id)
    {
        $transaksi = Transaksi::with('kamar', 'user')->findOrFail($id);

        $pdf = Pdf::loadView('frontend.pembayaran.pdf.invoice-pdf', [
            'transaksi' => $transaksi,
        ]);

        return $pdf->download("invoice-pembayaran-{$transaksi->kode}.pdf");
    }
}
