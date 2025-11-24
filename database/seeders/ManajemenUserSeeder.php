<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Illuminate\Support\Facades\Hash; // Import Hash Facade

class ManajemenUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Akun Manajemen Kampus
        DB::table('users')->insert([
            'name' => 'Manajer Kampus',
            'email' => 'manajer@pmb.com',
            'password' => Hash::make('12345678'),
            'role' => 'manajemen', // Role baru untuk Manajemen Kampus
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
