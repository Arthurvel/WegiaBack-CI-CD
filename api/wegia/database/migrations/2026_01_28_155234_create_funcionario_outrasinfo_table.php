<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionario_outrasinfo', function (Blueprint $table) {
            $table->increments('idfunncionario_outrasinfo');

            $table->unsignedInteger('funcionario_id_funcionario');
            $table->unsignedInteger('funcionario_listainfo_idfuncionario_listainfo');

            $table->string('dado', 255);

            // Índices
            $table->index(
                'funcionario_id_funcionario',
                'fk_funncionario_outrasinfo_funcionario1_idx'
            );

            $table->index(
                'funcionario_listainfo_idfuncionario_listainfo',
                'fk_funcionario_outrasinfo_funcionario_listainfo1_idx'
            );

            // Foreign Keys
            $table->foreign(
                'funcionario_id_funcionario',
                'fk_funncionario_outrasinfo_funcionario1'
            )
                ->references('id_funcionario')
                ->on('funcionario')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign(
                'funcionario_listainfo_idfuncionario_listainfo',
                'fk_funcionario_outrasinfo_funcionario_listainfo1'
            )
                ->references('idfuncionario_listainfo')
                ->on('funcionario_listainfo')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionario_outrasinfo');
    }
};
