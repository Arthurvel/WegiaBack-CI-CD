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
        Schema::create('pet_medicamento', function (Blueprint $table) {
            $table->id('id_medicamento');
            $table->string('nome_medicamento', 200);
            $table->string('descricao_medicamento', 200);
            $table->string('aplicacao', 250);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_medicamento');
    }
};
