<?php

/**
 * Migration untuk menambahkan kolom image ke tabel sub_categories.
 *
 * Kolom ini menyimpan path gambar thumbnail sub kategori di disk 'public'.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            // Tambahkan kolom hanya jika belum ada
            if (! Schema::hasColumn('sub_categories', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            if (Schema::hasColumn('sub_categories', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
