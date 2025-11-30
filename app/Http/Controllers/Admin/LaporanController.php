<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;

class LaporanController extends Controller
{
    public function index()
    {
        $penghuniMenunggak = User::with([
            'transaksi' => function ($q) {
                $q->where('tanggal_jatuhtempo', '<', now());
            },
            'kamar'
        ])
            ->whereHas('transaksi', function ($q) {
                $q->where('tanggal_jatuhtempo', '<', now());
            })
            ->whereNotNull('id_kamar')
            ->get()
            ->map(function ($user) {
                $user->hari_tunggakan = $user->transaksi->sum(function ($transaksi) {
                    return $transaksi->tanggal_jatuhtempo
                        ? now()->diffInDays($transaksi->tanggal_jatuhtempo, false)
                        : 0;
                });
                return $user;
            });

        return view('admin.laporan.data', [
            'transaksi' => Transaksi::with('user', 'kamar')->get(),
            'kamar' => Kamar::get(),
            'penghuni' => User::where('role', 'penghuni')->get(),
            'penghuniMenunggak' => $penghuniMenunggak,
        ]);
    }
}
