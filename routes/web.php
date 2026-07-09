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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik — Buku Tamu Digital (diakses via scan QR Code, tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('guest.form'));
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

    // Dashboard — semua role bisa mengakses (Admin, Petugas, Pimpinan)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Riwayat & filter — semua role
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // Laporan — semua role bisa lihat/cetak, Pimpinan hanya unduh (view sama, aksi ditombolkan)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'excel'])->name('laporan.excel');

    // QR Code — khusus Admin & Petugas (tanpa middleware role ganda)
    Route::get('/qrcode', [QrCodeController::class, 'show'])
        ->name('qrcode.show')
        ->middleware('role:admin,petugas');

    // Kunjungan — khusus Admin & Petugas (kelola, verifikasi, input manual)
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

    // Kelola Pengguna — khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);

        // Data Master — khusus Admin
        Route::get('/master-data', [MasterDataController::class, 'index'])->name('master.index');

        Route::post('/master-data/instansi', [MasterDataController::class, 'storeInstansi'])->name('master.instansi.store');
        Route::patch('/master-data/instansi/{instansi}/toggle', [MasterDataController::class, 'toggleInstansi'])->name('master.instansi.toggle');
        Route::delete('/master-data/instansi/{instansi}', [MasterDataController::class, 'destroyInstansi'])->name('master.instansi.destroy');

        Route::post('/master-data/tujuan', [MasterDataController::class, 'storeTujuan'])->name('master.tujuan.store');
        Route::patch('/master-data/tujuan/{tujuan}/toggle', [MasterDataController::class, 'toggleTujuan'])->name('master.tujuan.toggle');
        Route::delete('/master-data/tujuan/{tujuan}', [MasterDataController::class, 'destroyTujuan'])->name('master.tujuan.destroy');

        Route::post('/master-data/bidang', [MasterDataController::class, 'storeBidang'])->name('master.bidang.store');
        Route::patch('/master-data/bidang/{bidang}/toggle', [MasterDataController::class, 'toggleBidang'])->name('master.bidang.toggle');
        Route::delete('/master-data/bidang/{bidang}', [MasterDataController::class, 'destroyBidang'])->name('master.bidang.destroy');
    });
});