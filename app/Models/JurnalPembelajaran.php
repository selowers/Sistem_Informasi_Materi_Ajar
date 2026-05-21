<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[\Illuminate\Database\Eloquent\Attributes\Fillable(['tanggal_pembelajaran','guru_id','mata_pelajaran_id','kelas_id','materi_disampaikan','jumlah_hadir','jumlah_tidak_hadir','catatan_pembelajaran','kendala_pembelajaran'])]
class JurnalPembelajaran extends Model
{
    use HasFactory;

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
