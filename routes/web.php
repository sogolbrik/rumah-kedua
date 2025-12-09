<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\frontend\BookingPageController;
use App\Http\Controllers\frontend\LandingPageController;
use App\Http\Controllers\frontend\PembayaranPageController;
use App\Http\Controllers\frontend\user\PembayaranPenghuniController;
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
//MasterData
Route::resource('kamar', KamarController::class);
Route::resource('user', UserController::class);
Route::resource('galeri', GaleriController::class);
//Laporan
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::get('transaksi', [LaporanController::class, 'laporanTransaksi'])->name('transaksi');
    Route::get('kamar', [LaporanController::class, 'laporanKamar'])->name('kamar');
    Route::get('penghuni', [LaporanController::class, 'laporanPenghuni'])->name('penghuni');
    //Export Laporan
    Route::prefix('transaksi/export')->name('transaksi.export.')->group(function () {
        Route::get('pdf', [LaporanController::class, 'exportTransaksiPdf'])->name('pdf');
        Route::get('excel', [LaporanController::class, 'exportTransaksiExcel'])->name('excel');
    });
    Route::prefix('kamar/export')->name('kamar.export.')->group(function () {
        Route::get('pdf', [LaporanController::class, 'exportKamarPdf'])->name('pdf');
        Route::get('excel', [LaporanController::class, 'exportKamarExcel'])->name('excel');
    });
    Route::prefix('penghuni/export')->name('penghuni.export.')->group(function () {
        Route::get('pdf', [LaporanController::class, 'exportPenghuniPdf'])->name('pdf');
        Route::get('excel', [LaporanController::class, 'exportPenghuniExcel'])->name('excel');
    });
});
//Profil
Route::prefix('profil-admin')->name('profil-admin.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::put('/', [ProfilController::class, 'update'])->name('update');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('update-password');
    Route::put('/avatar', [ProfilController::class, 'updateAvatar'])->name('update-avatar');
});
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
//Pengaturan
Route::get('pengaturan-admin', [PengaturanController::class, 'index'])->name('pengaturan-admin.index');
Route::put('pengaturan-admin', [PengaturanController::class, 'update'])->name('pengaturan-admin.update');
Route::put('pengaturan-admin/hapus-logo', [PengaturanController::class, 'hapusLogo'])->name('pengaturan-admin.hapus-logo');

/* EndMiddlewareAdmin */

//Frontend
/* OutMiddleware */
//Landingpage
Route::get('/', [LandingPageController::class, 'landingPage'])->name('landing-page');
Route::get('galeri-kamar', [LandingPageController::class, 'galeri'])->name('galeri-kamar');
Route::get('booking', [BookingPageController::class, 'booking'])->name('booking');
Route::get('booking-detail/{id}', [BookingPageController::class, 'bookingDetail'])->name('booking-detail');
/* EndOutMiddleware */
Route::middleware('auth')->group(function () {
    Route::get('booking-pembayaran/{id}', [PembayaranPageController::class, 'pembayaran'])->name('pembayaran');
    //pembayaran
    Route::post('pembayaran/store', [PembayaranPageController::class, 'store'])->name('pembayaran.store');
    Route::get('pembayaran/{id}', [PembayaranPageController::class, 'invoicePembayaran'])->name('pembayaran.invoice');
});

//penghuni
Route::middleware('auth')->group(function () {
    //Dashbiard
    Route::get('dashboard-penghuni', [PenghuniController::class, 'index'])->name('dashboard-penghuni');
    //Profil
    Route::prefix('profil-penghuni')->name('profil-penghuni.')->group(function () {
        Route::get('/', [PenghuniController::class, 'profil'])->name('index');
        Route::put('/', [PenghuniController::class, 'update'])->name('update');
        Route::put('/password', [PenghuniController::class, 'updatePassword'])->name('update-password');
        Route::put('/avatar', [PenghuniController::class, 'updateAvatar'])->name('update-avatar');
    });
    //Transaksi Jatuh Tempo
    // Di dalam grup middleware auth & role penghuni
    Route::prefix('penghuni')->name('penghuni.')->group(function () {
        Route::get('/pembayaran', [PembayaranPenghuniController::class, 'index'])->name('pembayaran');
        Route::post('/pembayaran/buat-transaksi', [PembayaranPenghuniController::class, 'buatTransaksiBaru'])->name('pembayaran.buat-transaksi');
        Route::post('/pembayaran/bayar', [PembayaranPenghuniController::class, 'bayarTagihan'])->name('pembayaran.bayar');
    });
});

Route::get('tes', function (){
    return view('frontend.user.pembayaran-penghuni');
});

/* OutMiddleware */
//Admin
Route::get('/payment/check', [TransaksiController::class, 'checkStatus']);
//Penghuni
Route::get('pembayaran/check', [PembayaranPageController::class, 'checkStatus'])->name('pembayaran.check');
/* EndOutMiddleware */
