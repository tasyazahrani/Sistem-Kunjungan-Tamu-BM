<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik — Landing Page & Buku Tamu Digital
|--------------------------------------------------------------------------
*/

// Landing Page (beranda publik)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Buku Tamu Digital (diakses via scan QR Code, tanpa login)
Route::get('/buku-tamu', [GuestController::class, 'create'])->name('guest.form');
Route::post('/buku-tamu', [GuestController::class, 'store'])->name('guest.store');
Route::get('/buku-tamu/sukses/{kunjungan}', [GuestController::class, 'success'])->name('guest.success');

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Area Internal — wajib login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard — semua role bisa mengakses
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Riwayat & filter — semua role
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // Laporan — semua role
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'excel'])->name('laporan.excel');

    // QR Code — khusus Admin & Petugas
    Route::get('/qrcode', [QrCodeController::class, 'show'])
        ->name('qrcode.show')
        ->middleware('role:admin,petugas');

    // Kunjungan — khusus Admin & Petugas
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
        Route::get('/kunjungan/create', [KunjunganController::class, 'create'])->name('kunjungan.create');
        Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
        Route::get('/kunjungan/{kunjungan}', [KunjunganController::class, 'show'])->name('kunjungan.show');
        Route::get('/kunjungan/{kunjungan}/edit', [KunjunganController::class, 'edit'])->name('kunjungan.edit');
        Route::put('/kunjungan/{kunjungan}', [KunjunganController::class, 'update'])->name('kunjungan.update');
        Route::patch('/kunjungan/{kunjungan}/verifikasi', [KunjunganController::class, 'verifikasi'])->name('kunjungan.verifikasi');
        Route::delete('/kunjungan/{kunjungan}', [KunjunganController::class, 'destroy'])->name('kunjungan.destroy');
    });

    // Kelola Pengguna & Data Master — khusus Admin
    Route::middleware('role:admin')->group(function () {
        // USERS - Tambahkan ini
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        // Route::resource('users', UserController::class)->except(['show']);

        // Data Master
        Route::get('/master-data', [MasterDataController::class, 'index'])->name('master.index');

        // Instansi
        Route::post('/master-data/instansi', [MasterDataController::class, 'storeInstansiAjax'])->name('master.instansi.store.ajax');
        Route::put('/master-data/instansi/{instansi}', [MasterDataController::class, 'updateInstansiAjax'])->name('master.instansi.update.ajax');
        Route::patch('/master-data/instansi/{instansi}/toggle-ajax', [MasterDataController::class, 'toggleInstansiAjax'])->name('master.instansi.toggle.ajax');
        Route::delete('/master-data/instansi/{instansi}/delete-ajax', [MasterDataController::class, 'destroyInstansiAjax'])->name('master.instansi.destroy.ajax');

        // Tujuan
        Route::post('/master-data/tujuan', [MasterDataController::class, 'storeTujuanAjax'])->name('master.tujuan.store.ajax');
        Route::put('/master-data/tujuan/{tujuan}', [MasterDataController::class, 'updateTujuanAjax'])->name('master.tujuan.update.ajax');
        Route::patch('/master-data/tujuan/{tujuan}/toggle-ajax', [MasterDataController::class, 'toggleTujuanAjax'])->name('master.tujuan.toggle.ajax');
        Route::delete('/master-data/tujuan/{tujuan}/delete-ajax', [MasterDataController::class, 'destroyTujuanAjax'])->name('master.tujuan.destroy.ajax');

        // Bidang
        Route::post('/master-data/bidang', [MasterDataController::class, 'storeBidangAjax'])->name('master.bidang.store.ajax');
        Route::put('/master-data/bidang/{bidang}', [MasterDataController::class, 'updateBidangAjax'])->name('master.bidang.update.ajax');
        Route::patch('/master-data/bidang/{bidang}/toggle-ajax', [MasterDataController::class, 'toggleBidangAjax'])->name('master.bidang.toggle.ajax');
        Route::delete('/master-data/bidang/{bidang}/delete-ajax', [MasterDataController::class, 'destroyBidangAjax'])->name('master.bidang.destroy.ajax');
    });

    // ============================================
    // NOTIFIKASI — semua role yang login
    // ============================================
    
    // Halaman notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    // API untuk AJAX (real-time)
    Route::prefix('api/notifications')->name('api.notifications.')->group(function () {
        Route::get('/latest', [NotificationController::class, 'getLatest'])->name('latest');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });
});