<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[\Illuminate\Database\Eloquent\Attributes\Fillable(['nama_kelas','wali_kelas_id','tahun_ajaran','jumlah_santri'])]
class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }

    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    public function jurnalPembelajarans()
    {
        return $this->hasMany(JurnalPembelajaran::class);
    }
}
