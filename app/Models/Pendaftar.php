<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    // INI YANG KURANG: Memberi izin kolom mana saja yang boleh diisi
    protected $fillable = [
        'user_id',
        'nisn',
        'asal_sekolah',
        'no_hp',
        'path_foto',
        'path_ijazah',
        'status_berkas',
        'status_bayar',
        'status_lulus'
    ];

    // Relasi ke User (Opsional tapi berguna nanti)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
