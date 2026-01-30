<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionario_remuneracao', function (Blueprint $table) {
            $table->increments('idfuncionario_remuneracao');

            $table->unsignedInteger('funcionario_id_funcionario');
            $table->unsignedInteger('funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo');

            $table->decimal('valor', 10, 2);
            $table->date('inicio')->nullable();
            $table->date('fim')->nullable();

            // Índices
            $table->index('funcionario_id_funcionario', 'fk_funcionario_remuneracao_funcionario1_idx');
            $table->index(
                'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo',
                'fk_funcionario_remuneracao_funcionario_remuneracao_tipo1_idx'
            );

            // Foreign Keys
            $table->foreign(
                'funcionario_id_funcionario',
                'fk_funcionario_remuneracao_funcionario1'
            )
                ->references('id_funcionario')
                ->on('funcionario')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign(
                'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo',
                'fk_funcionario_remuneracao_funcionario_remuneracao_tipo1'
            )
                ->references('idfuncionario_remuneracao_tipo')
                ->on('funcionario_remuneracao_tipo')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionario_remuneracao');
    }
};

