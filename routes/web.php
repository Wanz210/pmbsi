<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Halaman Depan & Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');

Route::middleware(['auth'])->group(function () {

    // 1. USER (Calon Maba)
    Route::middleware(['role:user'])->prefix('maba')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/formulir', [DashboardController::class, 'userForm'])->name('user.form');
        Route::post('/formulir', [DashboardController::class, 'storeFormulir'])->name('user.form.store');
        Route::get('/kartu-ujian', [DashboardController::class, 'userCetakKartu'])->name('user.kartu');
        Route::get('/kelulusan', [DashboardController::class, 'userStatusLulus'])->name('user.kelulusan');
    });

    // 2. ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/verifikasi', [DashboardController::class, 'adminVerifikasi'])->name('admin.verifikasi');
        Route::post('/verifikasi/{id}', [DashboardController::class, 'prosesVerifikasi'])->name('admin.verifikasi.proses');
        Route::get('/users', [DashboardController::class, 'adminUsers'])->name('admin.users');
        Route::delete('/users/{id}', [DashboardController::class, 'destroyUser'])->name('admin.users.delete');
        Route::get('/jadwal', [DashboardController::class, 'adminJadwal'])->name('admin.jadwal');
        Route::post('/jadwal', [DashboardController::class, 'storeJadwal'])->name('admin.jadwal.store');
        Route::get('/jadwal', [DashboardController::class, 'adminJadwal'])->name('admin.jadwal');
        Route::delete('/jadwal/{id}', [DashboardController::class, 'destroyJadwal'])->name('admin.jadwal.delete');
        Route::put('/jadwal/{id}', [DashboardController::class, 'updateJadwal'])->name('admin.jadwal.update');
        Route::get('/kelulusan', [DashboardController::class, 'adminKelulusan'])->name('admin.kelulusan');
        Route::post('/kelulusan/{id}', [DashboardController::class, 'prosesKelulusan'])->name('admin.kelulusan.proses');
    });

    // ==========================================================
    // MANAJEMEN KAMPUS ROUTE GROUP (GABUNGAN KEUANGAN & PIMPINAN)
    // ==========================================================
    Route::middleware(['auth', 'role:keuangan,pimpinan,manajemen'])->prefix('manajemen')->name('manajemen.')->group(function () {

        // DASHBOARD (Gabungan Ringkasan Keuangan dan Eksekutif)
        Route::get('/dashboard', [DashboardController::class, 'manajemenDashboard'])->name('dashboard');

        // FUNGSI KEUANGAN
        Route::get('/validasi-pembayaran', [DashboardController::class, 'keuanganValidasi'])->name('validasi.pembayaran');
        Route::post('/validasi-pembayaran/{id}', [DashboardController::class, 'prosesPembayaran'])->name('validasi.proses');
        Route::get('/laporan-keuangan', [DashboardController::class, 'keuanganLaporan'])->name('laporan.keuangan');

        // FUNGSI PIMPINAN (Laporan Eksekutif)
        Route::get('/laporan-pendaftar', [DashboardController::class, 'pimpinanLaporanPendaftar'])->name('laporan.pendaftar');
        Route::get('/laporan-kelulusan', [DashboardController::class, 'pimpinanLaporanKelulusan'])->name('laporan.kelulusan');

    });
});
