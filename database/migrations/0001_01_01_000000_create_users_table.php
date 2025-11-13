<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // === PERBAIKAN DI SINI ===
            // Pastikan 'kontributor' ada di dalam daftar ENUM.
            // Anda juga bisa mengganti 'user' dengan 'kontributor' jika 'user' tidak dipakai.
            $table->enum('role', ['admin', 'kontributor', 'user'])->default('user');
            // ===========================
            
            // JIKA ANDA TIDAK MAU PAKAI ENUM (Alternatif):
            // $table->string('role', 20)->default('user'); // Gunakan string biasa

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};