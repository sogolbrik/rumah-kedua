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
        return view('admin.laporan.data', [
            'transaksi' => Transaksi::with('user', 'kamar')->get(),
            'kamar'     => Kamar::get(),
            'penghuni'  => User::where('role', 'penghuni')->get()
        ]);
    }
}
