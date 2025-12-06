<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AkunSeeder::class, // Panggil file AkunSeeder yang sudah diperbaiki
        ]);
    }
}
