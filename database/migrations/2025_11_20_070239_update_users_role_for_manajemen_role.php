<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // WAJIB: Import DB Facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // [PERBAIKAN] Menggunakan ALTER TABLE untuk menambahkan nilai 'manajemen' ke ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'keuangan', 'pimpinan', 'user', 'manajemen') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // [OPSIONAL] Mengembalikan ke kondisi semula (menghapus 'manajemen' dari ENUM)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'keuangan', 'pimpinan', 'user') NOT NULL");
    }
};
