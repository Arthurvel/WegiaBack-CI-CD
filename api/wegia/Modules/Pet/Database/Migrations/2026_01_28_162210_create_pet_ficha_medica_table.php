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
        Schema::create('pet_ficha_medica', function (Blueprint $table) {
            $table->id('id_ficha_medica');

            $table->foreignId('id_pet')
                ->constrained('pet', 'id_pet');

            $table->char('castrado', 1);
            $table->string('necessidades_especiais', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_ficha_medica');
    }
};
