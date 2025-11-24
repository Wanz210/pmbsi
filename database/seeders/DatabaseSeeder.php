<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pmb.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);

        // 2. Akun MANAJEMEN KAMPUS (Gabungan Keuangan & Pimpinan)
        User::create([
            'name' => 'Manajemen Kampus',
            'email' => 'manajer@pmb.com',
            'password' => Hash::make('12345678'),
            'role' => 'manajemen'
        ]);

        // 3. Akun USER (Contoh Calon Mahasiswa)
        User::create([
            'name' => 'Calon Mahasiswa',
            'email' => 'maba@pmb.com',
            'password' => Hash::make('12345678'),
            'role' => 'user'
        ]);
    }
}
