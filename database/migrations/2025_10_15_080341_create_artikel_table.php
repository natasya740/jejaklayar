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
    Schema::create('artikel', function (Blueprint $table) {
        $table->id('id_artikel');
        $table->unsignedBigInteger('id_kategori');
        $table->unsignedBigInteger('id_user')->nullable();
        $table->string('judul', 200);
        $table->string('subjudul', 250)->nullable();
        $table->string('gambar', 250)->nullable();
        $table->longText('isi');
        $table->enum('status', ['pending', 'draft', 'published', 'rejected'])->default('draft');
        $table->timestamps(); // <-- ini otomatis buat created_at & updated_at
        $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();

        // foreign key
        $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('set null');
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
