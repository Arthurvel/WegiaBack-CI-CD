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
        Schema::create('atendido_ocorrencia_doc', function (Blueprint $table) {
            $table->increments('idatendido_ocorrencia_doc');

            $table->unsignedInteger('atentido_ocorrencia_idatentido_ocorrencias');
            $table->timestamp('data');
            $table->string('arquivo_nome', 255);
            $table->string('arquivo_extensao', 200);
            $table->string('arquivo', 255);

            $table->index(
                'atentido_ocorrencia_idatentido_ocorrencias',
                'fk_atendido_ocorrencia_doc_atentido_ocorrencia1_idx'
            );

            $table->foreign(
                'atentido_ocorrencia_idatentido_ocorrencias',
                'fk_atendido_ocorrencia_doc_atentido_ocorrencia1'
            )
                ->references('idatendido_ocorrencias')->on('atendido_ocorrencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendido_ocorrencia_doc');
    }
};
