<?php

namespace App\Providers;

use App\Models\PengaturanSistem;
use App\Models\Transaksi;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pastikan locale Laravel ke Indonesia
        App::setLocale('id');

        // Atur locale Carbon global
        Carbon::setLocale('id');

        // User Observer
        User::observe(UserObserver::class);

        // Share notifikasi penghuni menunggak ke layout admin
        View::composer('layouts.admin-main', function ($view) {
            $penghuni = User::with([
                'transaksi' => function ($q) {
                    $q->orderBy('id', 'desc')->limit(1); // transaksi terakhir
                },
            ])
                ->where('role', 'penghuni')
                ->whereHas('transaksi', function ($q) {
                    $q->whereDate('tanggal_jatuhtempo', '<', Carbon::today());
                    $q->where('status_pembayaran', 'lunas');
                })
                ->latest();

            $view->with('penghuni', $penghuni);
            $view->with('penghuniCount', $penghuni->count());
        });

        // Share data pengaturan sistem ke semua view
        View::composer(['layouts.frontend-main', 'layouts.admin-main'], function ($view) {
            $pengaturan = PengaturanSistem::first();
            $view->with('pengaturan', $pengaturan);
        });

        // View Composer untuk alert transaksi pending
        View::composer('frontend.booking', function ($view) {
            $user = Auth::user();
            $showPendingAlert = false;
            $pendingTransaksi = null;

            // Hanya untuk user yang login dan belum punya kamar
            if ($user && !$user->id_kamar) {
                // Cari transaksi pending terbaru
                $pendingTransaksi = Transaksi::with('kamar')
                    ->where('id_user', $user->id)
                    ->where('status_pembayaran', 'pending')
                    ->latest()
                    ->first();

                $showPendingAlert = $pendingTransaksi !== null;
            }

            $view->with([
                'showPendingAlert' => $showPendingAlert,
                'pendingTransaksi' => $pendingTransaksi
            ]);
        });
    }
}
