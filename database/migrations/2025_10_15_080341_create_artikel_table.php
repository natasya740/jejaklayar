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
        // Ganti 'artikel' dengan 'artikels' jika Anda lebih suka jamak
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();

            // === INI ADALAH PERBAIKANNYA ===
            // Kita gunakan foreignId('user_id') yang standar
            // dan mengaitkannya ('constrained') ke tabel 'users' (yang otomatis mencari 'id')
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users') // Mengacu ke 'id' di tabel 'users'
                  ->onDelete('set null'); // Jika user dihapus, artikel tidak terhapus
            
            // Kolom standar untuk artikel
            $table->string('judul');
            $table->string('slug')->unique(); // Untuk URL yang cantik
            $table->longText('isi');
            $table->string('gambar_header')->nullable(); // Untuk gambar
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};