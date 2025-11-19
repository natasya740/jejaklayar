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
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            
            // 1. RELASI (Foreign Keys)
            // Menghubungkan artikel dengan user penulis
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Menghubungkan artikel dengan kategori
            // Pastikan tabel 'categories' sudah ada sebelumnya!
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // 2. DATA UTAMA (Sesuai $fillable Model)
            $table->string('title');
            $table->string('slug')->unique(); // Slug harus unik
            $table->text('content'); // Pakai text agar muat banyak karakter
            $table->string('image')->nullable(); // Boleh kosong (nullable)
            $table->string('status')->default('draft'); // Default status adalah draft
            $table->text('feedback')->nullable(); // Feedback boleh kosong

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};