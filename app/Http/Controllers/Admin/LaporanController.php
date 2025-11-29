<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $laporan = $request->get('laporan', 'penghuni');

        return match ($laporan) {
            'penghuni' => $this->laporanPenghuni($request),
            'keuangan' => $this->laporanKeuangan($request),
            'pembayaran' => $this->laporanPembayaran($request),
            'kamar' => $this->laporanKamar($request),
            'tagihan' => $this->laporanTagihan($request),
            'aktivitas' => $this->laporanAktivitas($request),
            default => $this->laporanPenghuni($request),
        };
    }

    protected function laporanPenghuni(Request $request)
    {
        $query = User::where('role', 'penghuni')->with('kamar');
        if ($request->filled('kamar'))
            $query->where('id_kamar', $request->kamar);
        if ($request->filled('status'))
            $query->where('status_penghuni', $request->status);
        if ($request->filled('tanggal_masuk'))
            $query->whereDate('tanggal_masuk', $request->tanggal_masuk);

        return view('admin.laporan.data', [
            'laporan' => 'penghuni',
            'penghuni' => $query->get(),
            'kamarList' => Kamar::all(),
        ]);
    }

    protected function laporanKeuangan(Request $request)
    {
        $periode = $request->get('periode', 'bulan');
        $now = now();
        $start = match ($periode) {
            'hari' => $now->copy()->startOfDay(),
            'minggu' => $now->copy()->startOfWeek(),
            'tahun' => $now->copy()->startOfYear(),
            default => $now->copy()->startOfMonth(),
        };
        $end = match ($periode) {
            'hari' => $now->copy()->endOfDay(),
            'minggu' => $now->copy()->endOfWeek(),
            'tahun' => $now->copy()->endOfYear(),
            default => $now->copy()->endOfMonth(),
        };

        $pendapatan = Transaksi::where('status_pembayaran', 'paid')
            ->whereNotNull('tanggal_pembayaran')
            ->whereBetween('tanggal_pembayaran', [$start, $end])
            ->sum('total_bayar');

        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d M');
            $total = Transaksi::where('status_pembayaran', 'paid')
                ->whereNotNull('tanggal_pembayaran')
                ->whereDate('tanggal_pembayaran', $date)
                ->sum('total_bayar');
            $chartData[] = ['date' => $label, 'total' => (float) $total];
        }

        return view('admin.laporan.data', compact('pendapatan', 'chartData', 'periode'))
            ->with('laporan', 'keuangan');
    }

    protected function laporanPembayaran(Request $request)
    {
        $query = Transaksi::with(['user', 'kamar'])->orderBy('created_at', 'desc');
        if ($request->filled('status'))
            $query->where('status_pembayaran', $request->status);
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_jatuhtempo', [$request->start_date, $request->end_date]);
        }

        return view('admin.laporan.data', [
            'laporan' => 'pembayaran',
            'transaksis' => $query->paginate(15),
        ]);
    }

    protected function laporanKamar(Request $request)
    {
        // Eager load users yang berperan sebagai penghuni
        $kamar = Kamar::with([
            'users' => function ($q) {
                $q->where('role', 'penghuni');
            }
        ])->get();
        $totalKamar = $kamar->count();
        // Kamar terisi jika memiliki setidaknya satu user ber-role 'penghuni'
        $terisi = $kamar->filter(fn($k) => $k->users->isNotEmpty())->count();
        $kosong = $totalKamar - $terisi;
        $occupancyRate = $totalKamar > 0 ? round(($terisi / $totalKamar) * 100, 2) : 0;

        $kamarKosongLama = Kamar::where('status', 'Tersedia')
            ->orderBy('updated_at')
            ->limit(5)
            ->get();

        return view('admin.laporan.data', compact('kamar', 'occupancyRate', 'kamarKosongLama'))
            ->with('laporan', 'kamar');
    }

    protected function laporanTagihan(Request $request)
    {
        $today = now()->toDateString();
        $tagihan = Transaksi::with(['user', 'kamar'])
            ->where('tanggal_jatuhtempo', '>=', now()->subMonths(2))
            ->orderBy('tanggal_jatuhtempo', 'asc')
            ->get()
            ->map(function ($t) use ($today) {
                if ($t->status_pembayaran === 'paid') {
                    $t->status_tagihan = 'Lunas';
                } elseif ($t->tanggal_jatuhtempo < $today) {
                    $t->status_tagihan = 'Telat';
                } elseif ($t->tanggal_jatuhtempo == $today) {
                    $t->status_tagihan = 'Jatuh Tempo';
                } else {
                    $t->status_tagihan = 'Menunggu';
                }
                return $t;
            });

        return view('admin.laporan.data', compact('tagihan'))
            ->with('laporan', 'tagihan');
    }

    protected function laporanAktivitas(Request $request)
    {
        // Jika pakai laravel-auditing, ganti dengan:
        // $aktivitas = \OwenIt\Auditing\Models\Audit::with('user')->latest()->paginate(15);
        $aktivitas = collect();

        return view('admin.laporan.data', compact('aktivitas'))
            ->with('laporan', 'aktivitas');
    }

    public function export(Request $request, $type)
    {
        $laporan = $request->get('laporan');
        if (!in_array($laporan, ['penghuni', 'pembayaran', 'kamar'])) {
            return back()->withErrors(['error' => 'Laporan tidak didukung untuk ekspor.']);
        }

        $data = match ($laporan) {
            'penghuni' => User::where('role', 'penghuni')->with('kamar')->get(),
            'pembayaran' => Transaksi::with(['user', 'kamar'])->get(),
            'kamar' => Kamar::with([
                'users' => function ($q) {
                        $q->where('role', 'penghuni');
                    }
            ])->get(),
        };

        return match ($type) {
            'pdf' => Pdf::loadView("admin.laporan.exports.{$laporan}", compact('data'))
                ->download("laporan_{$laporan}_" . now()->format('Ymd') . ".pdf"),
            'excel' => Excel::download(new LaporanExport($data, $laporan), "laporan_{$laporan}_" . now()->format('Ymd') . ".xlsx"),
            'csv' => Excel::download(new LaporanExport($data, $laporan), "laporan_{$laporan}_" . now()->format('Ymd') . ".csv"),
            default => back()->withErrors(['error' => 'Format ekspor tidak valid.']),
        };
    }
}
