<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: jurnal_pembelajarans
     * Fungsi: Mengelola Jurnal Pembelajaran
     */
    public function up(): void
    {
        if (!Schema::hasTable('jurnal_pembelajarans')) {
            Schema::create('jurnal_pembelajarans', function (Blueprint $table) {
                $table->id();                                           // ID Jurnal (Primary Key)
                $table->date('tanggal_pembelajaran');                  // Tanggal Pembelajaran
                $table->foreignId('guru_id')                           // Nama Guru (FK)
                      ->constrained('gurus')
                      ->onDelete('restrict');
                $table->foreignId('mata_pelajaran_id')                 // Mata Pelajaran (FK)
                      ->constrained('mata_pelajarans')
                      ->onDelete('restrict');
                $table->foreignId('kelas_id')                          // Kelas (FK)
                      ->constrained('kelas')
                      ->onDelete('restrict');
                $table->text('materi_disampaikan');                    // Materi yang Disampaikan
                $table->unsignedInteger('jumlah_hadir')->default(0);   // Kehadiran Santri: jumlah hadir
                $table->unsignedInteger('jumlah_tidak_hadir')->default(0); // Kehadiran Santri: tidak hadir
                $table->text('catatan_pembelajaran')->nullable();      // Catatan Pembelajaran
                $table->text('kendala_pembelajaran')->nullable();      // Kendala Pembelajaran
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_pembelajarans');
    }
};
