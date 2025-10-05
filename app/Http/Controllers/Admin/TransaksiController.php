<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('admin.transaksi.data', [
            'transaksi' => Transaksi::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.transaksi.form');
    }

    public function store()
    {
        //
    }
}
