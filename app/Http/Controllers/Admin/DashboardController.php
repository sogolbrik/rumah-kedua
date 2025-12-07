<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pengumuman;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Persiapan label 12 bulan ---
        $labels = [];
        $yearMonthKeys = [];
        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonthsNoOverflow($i);
            $labels[] = $dt->isoFormat('MMM Y');
            $yearMonthKeys[] = $dt->format('Y-m');
        }

        // --- Ambil data penjualan ---
        $startDate = Carbon::now()->subMonthsNoOverflow(11)->startOfMonth();

        // Gunakan YEAR/MONTH agar lebih kompatibel di berbagai versi MySQL
        $salesRaw = DB::table('transaksis')
            ->selectRaw('YEAR(created_at) as y, MONTH(created_at) as m, SUM(total_bayar) as total')
            ->where('status_pembayaran', 'paid')
            ->where('created_at', '>=', $startDate)
            ->groupBy('y', 'm')
            ->get();

        // Key-kan hasil ke format YYYY-MM
        $salesData = $salesRaw->keyBy(function ($row) {
            return sprintf('%04d-%02d', $row->y, $row->m);
        });

        // --- Isi data (isi 0 untuk bulan kosong) ---
        $sales = [];
        foreach ($yearMonthKeys as $ym) {
            $sales[] = $salesData->has($ym) ? (float) $salesData->get($ym)->total : 0.0;
        }

        // --- Pie chart: status transaksi ---
        $statusCounts = DB::table('transaksis')
            ->select('status_pembayaran', DB::raw('COUNT(*) as count'))
            ->groupBy('status_pembayaran')
            ->pluck('count', 'status_pembayaran')
            ->toArray();

        return view('admin.dashboard', [
            'kamar' => Kamar::get(),
            'transaksi' => Transaksi::with('user', 'kamar')->latest()->get(),
            'pengumuman' => Pengumuman::latest()->get(),
            'monthlySalesLabels' => $labels,
            'monthlySalesData' => $sales,
            'statusCounts' => $statusCounts,
        ]);
    }
}
