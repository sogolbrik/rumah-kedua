<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TransaksiExport;
use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $penghuniMenunggak = User::with(['transaksi', 'kamar'])
            ->whereHas('transaksi', function ($query) {
                $query->where('status_pembayaran', 'paid')
                    ->whereDate('tanggal_jatuhtempo', '<', Carbon::today());
            })
            ->where('role', 'penghuni') // pastikan hanya penghuni
            ->get();

        return view('admin.laporan.data', [
            'transaksi' => Transaksi::where('status_pembayaran', 'paid')->latest()->get(),
            'kamar' => Kamar::latest()->get(),
            'penghuni' => User::where('role', 'penghuni')->latest()->get(),
            'penghuniMenunggak' => $penghuniMenunggak,
        ]);
    }

    public function laporanTransaksi(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai', now()->subMonth()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->get('tanggal_selesai', now()->toDateString());

        $query = Transaksi::whereBetween('created_at', [
            Carbon::parse($tanggalMulai)->startOfDay(),
            Carbon::parse($tanggalSelesai)->endOfDay(),
        ])->latest();

        return view('admin.laporan.detail.transaksi', [
            'transaksi' => $query->paginate(50),
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ]);
    }

    public function laporanKamar()
    {
        return view('admin.laporan.detail.kamar', [
            'kamar' => Kamar::latest()->paginate(50),
        ]);
    }

    public function laporanPenghuni()
    {
        return view('admin.laporan.detail.penghuni', [
            'penghuni' => User::where('role', 'penghuni')->latest()->paginate(50),
        ]);
    }

    public function exportTransaksiPdf(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai', now()->subMonth()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = $request->get('tanggal_selesai', now()->format('Y-m-d'));

        $transaksi = Transaksi::whereBetween('created_at', [
            Carbon::parse($tanggalMulai)->startOfDay(),
            Carbon::parse($tanggalSelesai)->endOfDay(),
        ])->latest()->get();

        $pdf = Pdf::loadView('admin.laporan.export.transaksi-pdf', [
            'transaksi' => $transaksi,
            'tanggalMulai' => Carbon::parse($tanggalMulai)->translatedFormat('d F Y'),
            'tanggalSelesai' => Carbon::parse($tanggalSelesai)->translatedFormat('d F Y'),
        ]);

        return $pdf->download("laporan-transaksi-{$tanggalMulai}-{$tanggalSelesai}.pdf");
    }

    public function exportTransaksiExcel(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai', now()->subMonth()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = $request->get('tanggal_selesai', now()->format('Y-m-d'));

        $transaksi = Transaksi::whereBetween('created_at', [
            Carbon::parse($tanggalMulai)->startOfDay(),
            Carbon::parse($tanggalSelesai)->endOfDay(),
        ])->latest()->get();

        return Excel::download(
            new TransaksiExport($transaksi),
            "laporan-transaksi-{$tanggalMulai}-{$tanggalSelesai}.xlsx"
        );
    }
}
