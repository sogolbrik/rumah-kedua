<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pengumuman;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'kamar' => Kamar::get(),
            'transaksi' => Transaksi::with('user', 'kamar')->latest()->get(),
            'pengumuman' => Pengumuman::latest()->get(),
        ]);
    }
}
