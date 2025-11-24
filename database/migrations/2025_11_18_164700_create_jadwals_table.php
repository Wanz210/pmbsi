<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();

            // Kolom Tambahan untuk Jadwal
            $table->string('judul', 255); // Judul kegiatan, wajib diisi
            $table->text('deskripsi')->nullable(); // Keterangan tambahan (opsional)
            $table->date('tanggal_mulai'); // Tanggal kegiatan dimulai (wajib diisi)
            $table->date('tanggal_selesai')->nullable(); // Tanggal kegiatan berakhir (opsional)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
