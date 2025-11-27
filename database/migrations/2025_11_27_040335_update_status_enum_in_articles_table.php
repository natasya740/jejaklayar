<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kita menggunakan Raw SQL Statement karena mengubah tipe ENUM 
        // menggunakan Schema Builder Laravel sering bermasalah pada beberapa versi DB.
        
        // Perintah ini akan mengubah kolom status untuk menerima: draft, pending, published, archived
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft', 'pending', 'published', 'archived') NOT NULL DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Sebelum mengembalikan struktur tabel, kita harus memastikan 
        // tidak ada data yang berstatus 'pending' agar tidak error.
        // Ubah semua yang 'pending' menjadi 'draft'.
        DB::table('articles')->where('status', 'pending')->update(['status' => 'draft']);

        // Kembalikan ke struktur awal (tanpa 'pending')
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft'");
    }
};  