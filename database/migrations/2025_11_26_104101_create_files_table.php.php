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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('filepath', 255);
            $table->uuid('fileable_id')->nullable();
            $table->string('fileable_type', 255);

            // Optional caption / alt jika diperlukan:
            // $table->string('caption')->nullable();
            // $table->string('alt')->nullable();

            $table->timestamps();

            // Index untuk polymorphic relation
            $table->index(['fileable_id', 'fileable_type'], 'fileable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
