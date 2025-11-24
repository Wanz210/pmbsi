<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // Baris ini penting agar Laravel tau ini adalah Seeder
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder // Ini pembungkus Class yang hilang tadi
{
    public function run(): void
    {
        $roles = ['admin', 'manajemen', 'user'];

        foreach ($roles as $role) {
            User::create([
                'name' => strtoupper($role) . ' SI',
                'email' => $role . '@pmb.com',
                'password' => Hash::make('12345678'), // Password sama semua
                'role' => $role
            ]);
        }
    }
}
