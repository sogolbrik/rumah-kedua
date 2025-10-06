<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
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
Route::get('transaksi-admin', [TransaksiController::class, 'index'])->name('transaksi-admin');
Route::get('transaksi-admin-create', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('transaksi-admin-create', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::post('transaksi-admin-destroy', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
//Pengumuman
Route::get('pengumuman-admin', [PengumumanController::class, 'index'])->name('pengumuman-admin');
