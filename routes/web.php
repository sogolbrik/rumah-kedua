<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\api\MidtransController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//AdminPanel
Route::get('dashboard-admin', [DashboardController::class, 'index'])->name('dashboard-admin');
Route::resource('kamar', KamarController::class);
Route::resource('user', UserController::class);
Route::put('user/{id}/nonaktifkan', [UserController::class, 'nonaktifkan'])->name('user.nonaktifkan');
Route::put('user/{id}/aktifkan', [UserController::class, 'aktifkan'])->name('user.aktifkan');
//Transaksi
Route::prefix('transaksi')->name('transaksi.')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('create');
    Route::post('/store', [TransaksiController::class, 'store'])->name('store');
    Route::get('/{id}/payment', [TransaksiController::class, 'payment'])->name('payment');
    Route::get('/{id}/status', [TransaksiController::class, 'checkStatus'])->name('status');
    Route::put('/{id}/cancel', [TransaksiController::class, 'cancel'])->name('cancel');
    Route::delete('/{id}', [TransaksiController::class, 'destroy'])->name('destroy');
});
/* Nanti diluar middleware */
Route::prefix('midtrans')->group(function () {
    Route::post('/notification', [MidtransController::class, 'handleNotification'])->name('midtrans.notification');
});

/* END ' Nanti diluar middleware */
//Pengumuman
Route::get('pengumuman-admin', [PengumumanController::class, 'index'])->name('pengumuman-admin');
