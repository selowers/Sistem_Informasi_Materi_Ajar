<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: kelas
     * Fungsi: Mengelola Data Kelas Diniyah
     */
    public function up(): void
    {
        if (!Schema::hasTable('kelas')) {
            Schema::create('kelas', function (Blueprint $table) {
                $table->id();                                           // ID Kelas (Primary Key)
                $table->string('nama_kelas', 100);                     // Nama Kelas (contoh: Ula 1, Wustho 2)
                $table->foreignId('wali_kelas_id')                     // Wali Kelas → relasi ke tabel gurus
                      ->nullable()
                      ->constrained('gurus')
                      ->onDelete('set null');
                $table->string('tahun_ajaran', 20);                    // Tahun Ajaran (contoh: 2025/2026)
                $table->unsignedInteger('jumlah_santri')->default(0);  // Jumlah Santri (auto/manual)
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
