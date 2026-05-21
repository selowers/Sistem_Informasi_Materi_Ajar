<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: santris
     * Fungsi: Mengelola Data Santri
     */
    public function up(): void
    {
        if (!Schema::hasTable('santris')) {
            Schema::create('santris', function (Blueprint $table) {
                $table->id();                                       // ID Santri (Primary Key)
                $table->string('nama_santri', 100);                 // Nama Santri
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']); // Jenis Kelamin
                $table->text('alamat');                             // Alamat
                $table->string('nama_orang_tua', 100);              // Nama Orang Tua / Wali
                $table->foreignId('kelas_id')                       // Kelas (FK)
                      ->constrained('kelas')
                      ->onDelete('restrict');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
