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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            
            // === PERBAIKAN DI SINI ===
            // 'foreignId' mencari 'user_id'
            // 'constrained' secara otomatis mengaitkannya ke kolom 'id' di tabel 'users'
            // Ini adalah cara Laravel yang benar, alih-alih merujuk ke 'id_user' secara manual.
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            // ===========================

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};