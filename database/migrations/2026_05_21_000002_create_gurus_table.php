<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: gurus
     * Fungsi: Mengelola Data Guru
     */
    public function up(): void
    {
        if (!Schema::hasTable('gurus')) {
            Schema::create('gurus', function (Blueprint $table) {
                $table->id();                                                        // ID Guru (Primary Key)
                $table->string('nama_guru', 100);                                    // Nama Guru
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);           // Jenis Kelamin
                $table->string('tempat_lahir', 100);                                 // Tempat Lahir
                $table->date('tanggal_lahir');                                       // Tanggal Lahir
                $table->text('alamat');                                              // Alamat
                $table->string('no_hp', 20);                                         // No. HP
                $table->foreignId('mata_pelajaran_id')                              // Mata Pelajaran (FK)
                      ->constrained('mata_pelajarans')
                      ->onDelete('restrict');
                $table->foreignId('user_id')                                        // Relasi ke akun login (FK)
                      ->nullable()
                      ->constrained('users')
                      ->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
