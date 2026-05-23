<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: materis
     * Fungsi: Mengelola Materi Pembelajaran
     */
    public function up(): void
    {
        if (!Schema::hasTable('materis')) {
            Schema::create('materis', function (Blueprint $table) {
                $table->id();                                           // ID Materi (Primary Key)
                $table->string('judul_materi', 150);                   // Judul Materi
                $table->foreignId('mata_pelajaran_id')                 // Mata Pelajaran (FK)
                      ->constrained('mata_pelajarans')
                      ->onDelete('restrict');
                $table->foreignId('kelas_id')                          // Kelas (FK)
                      ->constrained('kelas')
                      ->onDelete('restrict');
                $table->foreignId('guru_id')                           // Guru Pengampu (FK)
                      ->constrained('gurus')
                      ->onDelete('cascade');
                $table->string('file_materi', 255);                    // Path File Materi (PDF/DOC/PPT)
                $table->string('tipe_file', 10)->nullable();           // Ekstensi: pdf, doc, ppt, dll
                $table->text('deskripsi')->nullable();                 // Deskripsi tambahan (opsional)
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
