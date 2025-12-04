<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KamarExport;
use App\Exports\PenghuniExport;
use App\Exports\TransaksiExport;
use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Ambil semua penghuni + transaksi terakhir + kamar
        $penghuni = User::with([
            'transaksi' => function ($q) {
                $q->orderBy('id', 'desc')->limit(1); // transaksi terakhir
            },
            'kamar'
        ])
            ->where('role', 'penghuni')
            ->get();

        // 2. Filter penghuni yang menunggak
        $penghuniMenunggak = $penghuni->filter(function ($user) {
            $trx = $user->transaksi->first();

            if (!$trx)
                return false; // tidak punya transaksi → bukan menunggak
            if (!$trx->tanggal_jatuhtempo)
                return false;

            // jatuh tempo < hari ini → menunggak
            return Carbon::parse($trx->tanggal_jatuhtempo)
                ->lt(Carbon::today());
        });

        return view('admin.laporan.data', [
            'transaksi' => Transaksi::where('status_pembayaran', 'paid')->latest()->get(),
            'kamar' => Kamar::latest()->get(),
            'penghuni' => User::where('role', 'penghuni')->latest()->get(),
            'penghuniMenunggak' => $penghuniMenunggak,
        ]);
    }

    // VIEW SECTION
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

    public function laporanKamar(Request $request)
    {
        $tipe = $request->get('tipe');
        $status = $request->get('status');

        $query = Kamar::query();

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return view('admin.laporan.detail.kamar', [
            'kamar' => $query->latest()->paginate(50),
            'tipe' => $tipe,
            'status' => $status,
        ]);
    }

    public function laporanPenghuni()
    {
        // Ambil semua penghuni + transaksi terbaru
        $penghuni = User::with([
            'transaksi' => function ($q) {
                $q->orderBy('id', 'desc')->limit(1); // transaksi terakhir
            },
            'kamar'
        ])
            ->where('role', 'penghuni')
            ->latest()
            ->paginate(50);

        return view('admin.laporan.detail.penghuni', [
            'penghuni' => $penghuni,
        ]);
    }

    // EXPORT SECTION
    /* Transaksi */
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

    /* Kamar */
    public function exportKamarPdf(Request $request)
    {
        $tipe = $request->get('tipe');
        $status = $request->get('status');

        $query = Kamar::query();

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $kamar = $query->latest()->get();

        $pdf = Pdf::loadView('admin.laporan.export.kamar-pdf', [
            'kamar' => $kamar,
            'tipe' => $tipe,
            'status' => $status,
        ]);

        return $pdf->download("laporan-kamar" . ($tipe ? "-{$tipe}" : '') . ($status ? "-{$status}" : '') . ".pdf");
    }

    public function exportKamarExcel(Request $request)
    {
        $tipe = $request->get('tipe');
        $status = $request->get('status');

        $query = Kamar::query();

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $kamar = $query->latest()->get();

        return Excel::download(
            new KamarExport($kamar),
            "laporan-kamar" . ($tipe ? "-{$tipe}" : '') . ($status ? "-{$status}" : '') . ".xlsx"
        );
    }

    /* Penghuni */
    public function exportPenghuniPdf(Request $request)
    {
        // Ambil semua penghuni, beserta kamar dan transaksi terakhir
        $penghuni = User::where('role', 'penghuni')
            ->with([
                'kamar',
                'transaksi' => function ($q) {
                    $q->orderByDesc('id')->limit(1); // transaksi terakhir
                }
            ])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.laporan.export.penghuni-pdf', [
            'penghuni' => $penghuni,
        ]);

        return $pdf->download('laporan-penghuni.pdf');
    }

    public function exportPenghuniExcel(Request $request)
    {
        $penghuni = User::where('role', 'penghuni')
            ->with([
                'kamar',
                'transaksi' => function ($q) {
                    $q->orderByDesc('id')->limit(1);
                }
            ])
            ->latest()->get();

        $penghuniMenunggakData = collect();

        foreach ($penghuni as $p) {
            $last = $p->transaksi->first();

            if ($last && $last->tanggal_jatuhtempo < Carbon::today()) {
                $hariTunggakan = Carbon::parse($last->tanggal_jatuhtempo)->diffInDays(Carbon::today());
                $penghuniMenunggakData->put($p->id, $hariTunggakan);
            }
        }

        return Excel::download(
            new PenghuniExport($penghuni, $penghuniMenunggakData),
            "laporan-penghuni.xlsx"
        );
    }

}
