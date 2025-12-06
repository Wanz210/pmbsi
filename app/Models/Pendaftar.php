<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nisn',
        'asal_sekolah',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ayah',
        'nama_ibu',
        'alamat',
        'status_berkas',
        'status_bayar',
        'status_lulus',
        'path_foto',
        'path_ijazah'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
