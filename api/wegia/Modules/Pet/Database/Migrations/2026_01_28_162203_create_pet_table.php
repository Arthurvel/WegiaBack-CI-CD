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
        Schema::create('pet', function (Blueprint $table) {
            $table->id('id_pet');

            $table->string('nome', 200);
            $table->date('data_nascimento');
            $table->date('data_acolhimento');
            $table->char('sexo', 1);

            $table->string('caracteristicas_especificas', 250)->nullable();

            $table->foreignId('id_pet_foto')
                ->nullable()
                ->constrained('pet_foto', 'id_pet_foto');

            $table->foreignId('id_pet_especie')
                ->constrained('pet_especie', 'id_pet_especie');

            $table->foreignId('id_pet_raca')
                ->constrained('pet_raca', 'id_pet_raca');

            $table->enum('cor', [
                'Preto','Branco','Cinza','Marrom','Caramelo','Amarelo','Bege',
                'Dourado','Ruivo','Creme','Azul','Chocolate','Bicolor','Tricolor'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet');
    }
};
