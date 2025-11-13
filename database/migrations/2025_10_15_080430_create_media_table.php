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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // === INI ADALAH PERBAIKANNYA ===
            // 1. Buat kolom 'artikel_id' (standar Laravel)
            // 2. 'constrained' akan mengaitkannya ke 'id' di tabel 'artikel'
            // 3. 'onDelete('cascade')' berarti jika artikel dihapus, media terkait juga terhapus.
            $table->foreignId('artikel_id')
                  ->nullable()
                  ->constrained('artikel') // Mengacu ke 'id' di tabel 'artikel'
                  ->onDelete('cascade'); 
            // ================================

            // Kolom tambahan untuk media
            $table->string('path'); // Path ke file (mis: 'images/artikel/gambar.jpg')
            $table->string('tipe', 50)->default('image'); // Tipe file (image, video, pdf)
            $table->string('keterangan')->nullable(); // Teks alt atau keterangan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};