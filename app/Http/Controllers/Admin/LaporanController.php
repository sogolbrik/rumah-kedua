<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

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

    public function laporanTransaksi()
    {
        return view('admin.laporan.detail.transaksi', [
            'transaksi' => Transaksi::latest()->paginate(50),
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
}
