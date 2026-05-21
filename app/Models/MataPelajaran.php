<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[\Illuminate\Database\Eloquent\Attributes\Fillable(['nama_mapel','deskripsi'])]
class MataPelajaran extends Model
{
    use HasFactory;

    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }

    public function kurikulums()
    {
        return $this->hasMany(Kurikulum::class);
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
