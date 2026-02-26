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
        Schema::create('saude_medicacao', function (Blueprint $table) {
            $table->id('id_medicacao');

            $table->foreignId('id_atendimento')
                ->constrained('saude_atendimento', 'id_atendimento');

            $table->string('medicamento', 255);
            $table->string('dosagem', 100)->nullable();
            $table->string('horario', 100)->nullable();
            $table->string('duracao', 100)->nullable();

            $table->enum('status', ['Tratamento', 'Concluido', 'Substituido', 'Cancelado'])
                ->default('Tratamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_medicacao');
    }
};
