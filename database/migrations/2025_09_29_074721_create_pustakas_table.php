<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pustakas', function (Blueprint $table) {
            $table->id('id_pustaka');
            $table->string('judul');
            $table->string('penulis');
            $table->integer('tahun')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pustakas');
    }
};
