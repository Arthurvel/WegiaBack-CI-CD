<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quadro_horario_funcionario', function (Blueprint $table) {
            $table->increments('id_quadro_horario');

            $table->unsignedInteger('id_funcionario');
            $table->unsignedInteger('escala');
            $table->unsignedInteger('tipo');

            $table->string('carga_horaria', 200)->nullable();
            $table->string('entrada1', 200)->nullable();
            $table->string('saida1', 200)->nullable();
            $table->string('entrada2', 200)->nullable();
            $table->string('saida2', 200)->nullable();
            $table->string('total', 200)->nullable();
            $table->string('dias_trabalhados', 200)->nullable();
            $table->string('folga', 200)->nullable();

            // Índices
            $table->index('id_funcionario');
            $table->index('escala', 'quadro_horario_funcionario_ibfk_2');
            $table->index('tipo', 'quadro_horario_funcionario_ibfk_3');

            // Foreign Keys
            $table->foreign('id_funcionario', 'quadro_horario_funcionario_ibfk_1')
                ->references('id_funcionario')
                ->on('funcionario');

            $table->foreign('escala', 'quadro_horario_funcionario_ibfk_2')
                ->references('id_escala')
                ->on('escala_quadro_horario');

            $table->foreign('tipo', 'quadro_horario_funcionario_ibfk_3')
                ->references('id_tipo')
                ->on('tipo_quadro_horario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quadro_horario_funcionario');
    }
};
