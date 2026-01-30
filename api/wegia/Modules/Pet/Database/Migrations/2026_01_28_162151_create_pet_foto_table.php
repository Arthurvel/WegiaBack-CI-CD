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
        Schema::create('pet_foto', function (Blueprint $table) {
            $table->id('id_pet_foto');
            $table->string('arquivo_foto_pet', 255);
            $table->string('arquivo_foto_pet_nome', 200);
            $table->string('arquivo_foto_pet_extensao', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_foto');
    }
};
