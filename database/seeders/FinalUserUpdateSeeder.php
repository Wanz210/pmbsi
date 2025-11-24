<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Model User di-import

class FinalUserUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =======================================================
        // 1. HAPUS AKUN LAMA (Keuangan & Pimpinan)
        // =======================================================
        $deletedKeuangan = User::where('email', 'keuangan@pmb.com')->delete();
        $deletedPimpinan = User::where('email', 'pimpinan@pmb.com')->delete();

        // =======================================================
        // 2. BUAT AKUN BARU (Manajemen Kampus)
        // =======================================================
        $manajerExists = User::where('email', 'manajer@pmb.com')->exists();

        if (!$manajerExists) {
            DB::table('users')->insert([
                'name' => 'Manajer Kampus',
                'email' => 'manajer@pmb.com',
                'password' => Hash::make('12345678'),
                'role' => 'manajemen', // Role baru
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
