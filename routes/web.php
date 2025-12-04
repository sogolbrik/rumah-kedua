<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\frontend\BookingPageController;
use App\Http\Controllers\frontend\LandingPageController;
use App\Http\Controllers\frontend\PembayaranPageController;
use App\Http\Controllers\frontend\user\PenghuniController;
use Illuminate\Support\Facades\Route;

//Authentication
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'store'])->name('register.store');
Route::post('login', [AuthController::class, 'authentication'])->name('authentication');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

/* MiddlewareAdmin */
//AdminPanel
Route::get('dashboard-admin', [DashboardController::class, 'index'])->name('dashboard-admin');
//Master
Route::resource('kamar', KamarController::class);
Route::resource('user', UserController::class);
Route::resource('galeri', GaleriController::class);
//Laporan
Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('laporan/transaksi', [LaporanController::class, 'laporanTransaksi'])->name('laporan.transaksi');
Route::get('laporan/kamar', [LaporanController::class, 'laporanKamar'])->name('laporan.kamar');
Route::get('laporan/penghuni', [LaporanController::class, 'laporanPenghuni'])->name('laporan.penghuni');
//Export Laporan
Route::get('/laporan/transaksi/export/pdf', [LaporanController::class, 'exportTransaksiPdf'])->name('laporan.transaksi.pdf');
Route::get('/laporan/transaksi/export/excel', [LaporanController::class, 'exportTransaksiExcel'])->name('laporan.transaksi.excel');
Route::get('/laporan/kamar/export/pdf', [LaporanController::class, 'exportKamarPdf'])->name('laporan.kamar.pdf');
Route::get('/laporan/kamar/export/excel', [LaporanController::class, 'exportKamarExcel'])->name('laporan.kamar.excel');
Route::get('/laporan/penghuni/export/pdf', [LaporanController::class, 'exportPenghuniPdf'])->name('laporan.penghuni.pdf');
Route::get('/laporan/penghuni/export/excel', [LaporanController::class, 'exportPenghuniExcel'])->name('laporan.penghuni.excel');
//Nonaktif User
Route::put('user/{id}/nonaktifkan', [UserController::class, 'nonaktifkan'])->name('user.nonaktifkan');
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
//Pengumuman
Route::get('pengumuman-admin', [PengumumanController::class, 'index'])->name('pengumuman-admin');
Route::post('pengumuman-admin', [PengumumanController::class, 'store'])->name('pengumuman-admin.store');
/* EndMiddlewareAdmin */

/* OutMiddleware */
// Check
Route::get('/payment/check', [TransaksiController::class, 'checkStatus']);
/* EndOutMiddleware */

//Frontend
//Landingpage
Route::get('/', [LandingPageController::class, 'landingPage'])->name('landing-page');
Route::get('galeri-kamar', [LandingPageController::class, 'galeri'])->name('galeri-kamar');
Route::get('booking', [BookingPageController::class, 'booking'])->name('booking');
Route::get('booking-detail/{id}', [BookingPageController::class, 'bookingDetail'])->name('booking-detail');
Route::middleware('auth')->group(function () {
    Route::get('booking-pembayaran/{id}', [PembayaranPageController::class, 'pembayaran'])->name('pembayaran');
    //pembayaran
    Route::post('pembayaran/store', [PembayaranPageController::class, 'store'])->name('pembayaran.store');
    Route::get('pembayaran/{id}', [PembayaranPageController::class, 'invoicePembayaran'])->name('pembayaran.invoice');
    //penghuni
    Route::get('user/penghuni', [PenghuniController::class, 'index'])->name('user.penghuni');
});
/* OutMiddleware */
Route::get('pembayaran/check', [PembayaranPageController::class, 'checkStatus'])->name('pembayaran.check');
/* EndOutMiddleware */
