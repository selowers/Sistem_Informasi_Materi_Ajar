<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: mata_pelajarans
     * Fungsi: Master data mata pelajaran (digunakan oleh guru, kurikulum, materi, jurnal)
     */
    public function up(): void
    {
        if (!Schema::hasTable('mata_pelajarans')) {
            Schema::create('mata_pelajarans', function (Blueprint $table) {
                $table->id();                           // ID Mata Pelajaran (Primary Key)
                $table->string('nama_mapel', 100);      // Nama Mata Pelajaran
                $table->text('deskripsi')->nullable();  // Deskripsi (opsional)
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};
