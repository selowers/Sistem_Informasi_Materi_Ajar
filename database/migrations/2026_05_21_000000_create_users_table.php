<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: users
     * Fungsi: Login, Lupa Password, Ganti Password, Mengelola Akun Pengguna
     */
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();                                           // ID User (Primary Key)
                $table->string('nama', 100);                           // Nama Pengguna
                $table->string('email', 100)->unique();                // Email / Username
                $table->string('password', 255);                       // Password (bcrypt)
                $table->enum('role', ['admin', 'guru'])->default('guru'); // Role / Hak Akses
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif'); // Status Akun
                $table->string('remember_token', 100)->nullable();     // Remember Token (untuk session)
                $table->string('reset_token', 100)->nullable();        // Token Lupa Password
                $table->timestamp('reset_token_expiry')->nullable();   // Expiry Token Lupa Password
                $table->timestamps();                                  // Tanggal Dibuat & Diupdate
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
