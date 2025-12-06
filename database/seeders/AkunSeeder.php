<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AkunSeeder extends Seeder // Ubah nama kelas jika Anda menggunakan file AkunSeeder.php
{
    public function run(): void
    {
        // Password default
        $defaultPassword = Hash::make('12345678');

        // 1. Akun ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pmb.com',
            'password' => $defaultPassword,
            'role' => 'admin',
            'status' => 'active' // Akun sistem harus aktif
        ]);

        // 2. Akun MANAJEMEN KAMPUS (Gabungan Keuangan & Pimpinan)
        User::create([
            'name' => 'Manajemen Kampus',
            'email' => 'manajemen@pmb.com', // Gunakan manajemen@pmb.com agar konsisten dengan AuthController
            'password' => $defaultPassword,
            'role' => 'manajemen',
            'status' => 'active' // Akun sistem harus aktif
        ]);

        // 3. Akun USER (Contoh Calon Mahasiswa)
        User::create([
            'name' => 'User Default',
            'email' => 'user@pmb.com',
            'password' => $defaultPassword,
            'role' => 'user',
            'status' => 'pending' // User baru harus menunggu verifikasi
        ]);
    }
}
