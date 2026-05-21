<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[\Illuminate\Database\Eloquent\Attributes\Fillable(['nama_guru','jenis_kelamin','tempat_lahir','tanggal_lahir','alamat','no_hp','mata_pelajaran_id','user_id'])]
class Guru extends Model
{
    use HasFactory;

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
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
