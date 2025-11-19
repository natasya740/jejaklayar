<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            
            // === 💡 PERBAIKAN DI SINI 💡 ===
            // 'parent_id' untuk relasi self-referencing (Budaya > Seni)
            $table->unsignedBigInteger('parent_id')->nullable(); 
            // =============================
            
            $table->string('nama');
            $table->string('slug')->unique();
            
            // Definisi foreign key
            $table->foreign('parent_id')->references('id')->on('kategori')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};