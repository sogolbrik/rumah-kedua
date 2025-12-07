<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenghuniController extends Controller
{
    public function index()
    {
        $user = User::with('kamar', 'transaksi')->find(Auth::id());

        $transaksis = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->paginate(10);

        $totalTransaksi = $transaksis->total();

        $totalBayar = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'paid')
            ->sum('total_bayar');

        $terakhirBayar = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'paid')
            ->orderBy('tanggal_pembayaran', 'desc')
            ->value('tanggal_pembayaran'); // Carbon instance atau null

        $menunggak = Transaksi::where('id_user', $user->id)
            ->where('tanggal_jatuhtempo', '<', now()->toDateString())
            ->whereNotIn('id', function ($q) use ($user) {
                $q->select('id')
                  ->from('transaksis')
                  ->where('id_user', $user->id)
                  ->where('status_pembayaran', 'paid')
                  ->whereColumn('tanggal_jatuhtempo', 'transaksis.tanggal_jatuhtempo');
            })
            ->exists();

        return view('frontend.user.penghuni', compact(
            'user',
            'transaksis',
            'totalTransaksi',
            'totalBayar',
            'terakhirBayar',
            'menunggak'
        ));
    }
}
