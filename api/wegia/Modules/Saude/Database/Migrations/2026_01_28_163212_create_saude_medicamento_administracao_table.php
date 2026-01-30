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
        Schema::create('saude_medicamento_administracao', function (Blueprint $table) {
            $table->increments('idsaude_medicamento_administracao');

            $table->dateTime('registro')->useCurrent();
            $table->dateTime('aplicacao');

            $table->unsignedBigInteger('saude_medicacao_id_medicacao');

            $table->foreign(
                'saude_medicacao_id_medicacao',
                'fk_sm_adm_medicacao'
            )->references('id_medicacao')
                ->on('saude_medicacao')
                ->onDelete('cascade');

            $table->unsignedInteger('funcionario_id_funcionario');

            $table->foreign(
                'funcionario_id_funcionario',
                'fk_sm_adm_funcionario'
            )
                ->references('id_funcionario')
                ->on('funcionario')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_medicamento_administracao');
    }
};
