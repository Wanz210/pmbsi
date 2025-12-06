// database/migrations/2025_11_18_144752_create_pendaftars_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Biodata Tambahan (Harus Sesuai Form Register)
            $table->string('nisn')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();

            $table->enum('jalur', ['SNBP', 'SNBT', 'Mandiri', 'Lainnya'])->nullable();

            // Data Orang Tua
            $table->string('nama_ayah')->nullable(); // <-- KRUSIAL
            $table->string('nama_ibu')->nullable();  // <-- KRUSIAL
            $table->text('alamat')->nullable();

            // Status Sistem
            $table->enum('status_berkas', ['pending', 'valid', 'invalid'])->default('pending');
            $table->enum('status_bayar', ['belum', 'lunas'])->default('belum');
            $table->enum('status_lulus', ['proses', 'lulus', 'tidak'])->default('proses');

            // Upload File
            $table->string('path_foto')->nullable();
            $table->string('path_ijazah')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
