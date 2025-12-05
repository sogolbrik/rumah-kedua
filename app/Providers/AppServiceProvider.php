<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
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
                })
                ->latest();

            $view->with('penghuni', $penghuni);
            $view->with('penghuniCount', $penghuni->count());
        });
    }
}
