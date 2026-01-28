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
        Schema::create('atendido_ocorrencia', function (Blueprint $table) {
            $table->increments('idatendido_ocorrencias');

            $table->unsignedInteger('atendido_idatendido');
            $table->unsignedInteger('atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos');
            $table->unsignedInteger('funcionario_id_funcionario');

            $table->date('data');
            $table->string('descricao', 255)->nullable();

            $table->index('atendido_idatendido', 'fk_atentido_ocorrencias_atendido1_idx');
            $table->index(
                'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos',
                'fk_atentido_ocorrencias_atendido_ocorrencia_tipos1_idx'
            );
            $table->index('funcionario_id_funcionario', 'fk_atentido_ocorrencias_funcionario1_idx');

            $table->foreign('atendido_idatendido', 'fk_atentido_ocorrencias_atendido1')
                ->references('idatendido')->on('atendido');

            $table->foreign(
                'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos',
                'fk_atentido_ocorrencias_atendido_ocorrencia_tipos1'
            )
                ->references('idatendido_ocorrencia_tipos')->on('atendido_ocorrencia_tipos');

            $table->foreign('funcionario_id_funcionario', 'fk_atentido_ocorrencias_funcionario1')
                ->references('id_funcionario')->on('funcionario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendido_ocorrencia');
    }
};
