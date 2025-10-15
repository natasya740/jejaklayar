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
        $table->id('id_media');
        $table->unsignedBigInteger('id_artikel');
        $table->string('judul', 150)->nullable();
        $table->enum('tipe', ['foto', 'video', 'dokumen', 'ebook']);
        $table->string('path', 250);
        $table->text('deskripsi')->nullable();
        $table->timestamp('dibuat_pada')->useCurrent();

        // foreign key
        $table->foreign('id_artikel')->references('id_artikel')->on('artikel')->onDelete('cascade');
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
