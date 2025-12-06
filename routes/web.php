<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ==========================================================
// 1. HALAMAN LOGIN & REGISTRASI (Akses Umum)
// ==========================================================
Route::get('/', function () { return redirect()->route('login'); });

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================================
// 2. GROUP USER / CALON MAHASISWA (MABA)
// ==========================================================
Route::middleware(['auth', 'role:user'])->prefix('maba')->name('user.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard'); // Dashboard Info & Jadwal

    // [PENTING] Route Formulir Pendaftaran (Agar tombol di dashboard berfungsi)
    Route::get('/formulir', [DashboardController::class, 'userForm'])->name('formulir');
    Route::post('/formulir', [DashboardController::class, 'storeFormulir'])->name('formulir.store');

    Route::get('/cetak-kartu', [DashboardController::class, 'userCetakKartu'])->name('kartu'); // Cetak Kartu Ujian
    Route::get('/status-kelulusan', [DashboardController::class, 'userStatusLulus'])->name('kelulusan'); // Status
});


// ==========================================================
// 3. GROUP ADMIN (Administrator)
// ==========================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard'); // Dashboard (Statistik)

    // Verifikasi Berkas Pendaftaran
    Route::get('/verifikasi', [DashboardController::class, 'adminVerifikasi'])->name('verifikasi');
    Route::post('/verifikasi/{id}', [DashboardController::class, 'prosesVerifikasi'])->name('verifikasi.proses');

    // Manajemen User (Termasuk Verifikasi Akun Baru)
    Route::get('/users', [DashboardController::class, 'adminUsers'])->name('users');
    Route::delete('/users/{id}', [DashboardController::class, 'destroyUser'])->name('users.delete');
    // [PENTING] Route untuk tombol Terima/Tolak Akun di tabel kuning
    Route::get('/users/verifikasi/{id}/{status}', [DashboardController::class, 'verifikasiUser'])->name('verifikasi.user');

    // Pengaturan Jadwal Info
    Route::get('/jadwal', [DashboardController::class, 'adminJadwal'])->name('jadwal');
    Route::post('/jadwal', [DashboardController::class, 'storeJadwal'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [DashboardController::class, 'updateJadwal'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [DashboardController::class, 'destroyJadwal'])->name('jadwal.delete');

    // Manajemen Kelulusan
    Route::get('/kelulusan', [DashboardController::class, 'adminKelulusan'])->name('kelulusan');
    Route::post('/kelulusan/{id}', [DashboardController::class, 'prosesKelulusan'])->name('kelulusan.proses');
});


// ==========================================================
// 4. GROUP MANAJEMEN KAMPUS (Gabungan Keuangan & Pimpinan)
// ==========================================================
Route::middleware(['auth', 'role:manajemen'])->prefix('manajemen')->name('manajemen.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'manajemenDashboard'])->name('dashboard'); // Dashboard Ringkasan

    Route::get('/validasi-pembayaran', [DashboardController::class, 'manajemenValidasi'])->name('validasi'); // Validasi (Pembayaran)
    Route::post('/validasi-pembayaran/{id}', [DashboardController::class, 'prosesPembayaran'])->name('validasi.proses');

    Route::get('/laporan-keuangan', [DashboardController::class, 'manajemenLaporanKeuangan'])->name('laporan.keuangan'); // Laporan (Keuangan)
    Route::get('/laporan-pendaftar', [DashboardController::class, 'manajemenLaporanPendaftar'])->name('laporan.pendaftar'); // Laporan (Pendaftar)
    Route::get('/laporan-kelulusan', [DashboardController::class, 'manajemenLaporanKelulusan'])->name('laporan.kelulusan'); // Laporan (Kelulusan)
});
