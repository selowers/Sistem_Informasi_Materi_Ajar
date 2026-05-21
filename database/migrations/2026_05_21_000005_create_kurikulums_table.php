<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: kurikulums
     * Fungsi: Mengelola Kurikulum
     */
    public function up(): void
    {
        if (!Schema::hasTable('kurikulums')) {
            Schema::create('kurikulums', function (Blueprint $table) {
                $table->id();                                       // ID Kurikulum (Primary Key)
                $table->foreignId('mata_pelajaran_id')              // Mata Pelajaran (FK)
                      ->constrained('mata_pelajarans')
                      ->onDelete('cascade');
                $table->foreignId('kelas_id')                       // Tingkat Kelas (FK)
                      ->constrained('kelas')
                      ->onDelete('cascade');
                $table->string('tahun_ajaran', 20);                 // Tahun Ajaran (contoh: 2025/2026)
                $table->text('deskripsi')->nullable();              // Deskripsi kurikulum (opsional)
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};
