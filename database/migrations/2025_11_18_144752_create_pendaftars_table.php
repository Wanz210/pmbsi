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
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Data Bio
            $table->string('asal_sekolah')->nullable();
            $table->string('nisn')->nullable();
            $table->string('no_hp')->nullable();

            // Data Berkas
            $table->string('path_foto')->nullable();
            $table->string('path_ijazah')->nullable();

            // Status Verifikasi (Admin) & Pembayaran (Keuangan)
            $table->enum('status_berkas', ['pending', 'valid', 'invalid'])->default('pending');
            $table->enum('status_bayar', ['belum', 'lunas'])->default('belum');
            $table->enum('status_lulus', ['proses', 'lulus', 'tidak'])->default('proses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
