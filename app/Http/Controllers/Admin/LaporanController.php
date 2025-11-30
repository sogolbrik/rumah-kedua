<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.data', [
            'transaksi' => Transaksi::get()
        ]);
    }
}
