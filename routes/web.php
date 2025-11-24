<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// 1. HALAMAN LOGIN & REGISTRASI (Akses Umum)
Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// 2. GROUP USER / CALON MAHASISWA
Route::middleware(['auth', 'role:user'])->prefix('maba')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard'); // Dashboard Info & Jadwal
    Route::get('/formulir', [DashboardController::class, 'userForm'])->name('formulir'); // Formulir Pendaftaran
    Route::post('/formulir', [DashboardController::class, 'storeFormulir'])->name('formulir.store'); // Simpan Bio & Upload Berkas
    Route::get('/cetak-kartu', [DashboardController::class, 'userCetakKartu'])->name('cetak'); // Cetak Kartu Ujian
    Route::get('/status-kelulusan', [DashboardController::class, 'userStatusLulus'])->name('kelulusan'); // Status
});


// 3. GROUP ADMIN (Administrator)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard'); // Dashboard (Statistik)
    Route::get('/verifikasi', [DashboardController::class, 'adminVerifikasi'])->name('verifikasi'); // Verifikasi (Berkas)
    Route::post('/verifikasi/{id}', [DashboardController::class, 'prosesVerifikasi'])->name('verifikasi.proses');
    Route::get('/users', [DashboardController::class, 'adminUsers'])->name('users'); // Manajemen (User)
    Route::delete('/users/{id}', [DashboardController::class, 'destroyUser'])->name('users.delete');
    Route::get('/jadwal', [DashboardController::class, 'adminJadwal'])->name('jadwal'); // Pengaturan Jadwal Info
    Route::post('/jadwal', [DashboardController::class, 'storeJadwal'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [DashboardController::class, 'updateJadwal'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [DashboardController::class, 'destroyJadwal'])->name('jadwal.delete');
    Route::get('/kelulusan', [DashboardController::class, 'adminKelulusan'])->name('kelulusan'); // Manajemen Kelulusan
    Route::post('/kelulusan/{id}', [DashboardController::class, 'prosesKelulusan'])->name('kelulusan.proses');
});


// 4. GROUP MANAJEMEN KAMPUS (Gabungan Keuangan & Pimpinan)
Route::middleware(['auth', 'role:manajemen'])->prefix('manajemen')->name('manajemen.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'manajemenDashboard'])->name('dashboard'); // Dashboard Ringkasan
    Route::get('/validasi-pembayaran', [DashboardController::class, 'manajemenValidasi'])->name('validasi'); // Validasi (Pembayaran)
    Route::post('/validasi-pembayaran/{id}', [DashboardController::class, 'prosesPembayaran'])->name('validasi.proses');
    Route::get('/laporan-keuangan', [DashboardController::class, 'manajemenLaporanKeuangan'])->name('laporan.keuangan'); // Laporan (Keuangan)
    Route::get('/laporan-pendaftar', [DashboardController::class, 'manajemenLaporanPendaftar'])->name('laporan.pendaftar'); // Laporan (Pendaftar)
    Route::get('/laporan-kelulusan', [DashboardController::class, 'manajemenLaporanKelulusan'])->name('laporan.kelulusan'); // Laporan (Kelulusan)
});
