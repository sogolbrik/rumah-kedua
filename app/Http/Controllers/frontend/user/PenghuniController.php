<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenghuniController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan pengguna adalah penghuni dan punya kamar
        if ($user->role !== 'penghuni') {
            return redirect()->route('landing-page')->with('error', 'Hanya penghuni yang dapat mengakses halaman ini.');
        }

        if (!$user->id_kamar) {
            return redirect()->route('landing-page')->with('error', 'Anda belum ditempatkan di kamar. Hubungi admin.');
        }

        $kamar = Kamar::findOrFail($user->id_kamar);

        // Ambil transaksi yang jatuh tempo dalam 7 hari ke depan & belum dibayar
        $jatuhTempo = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'pending')
            ->whereDate('tanggal_jatuhtempo', '<=', now()->addDays(7))
            ->whereDate('tanggal_jatuhtempo', '>=', now())
            ->orderBy('tanggal_jatuhtempo', 'asc')
            ->first();

        // Riwayat transaksi (semua, urut terbaru)
        $riwayat = Transaksi::with('kamar')
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('frontend.user.penghuni', compact('kamar', 'jatuhTempo', 'riwayat'));
    }
}
