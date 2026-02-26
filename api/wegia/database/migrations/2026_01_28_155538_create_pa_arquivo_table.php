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
        Schema::create('pa_arquivo', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('id_processo')->nullable();
            $table->unsignedInteger('id_etapa')->nullable();

            $table->string('arquivo_nome', 255);
            $table->string('arquivo_extensao', 10);
            $table->string('arquivo', 255);
            $table->dateTime('data_upload')->useCurrent();

            $table->foreign('id_processo', 'fk_pa_arquivo_processo')
                ->references('id')->on('processo_de_aceitacao');

            $table->foreign('id_etapa', 'fk_pa_arquivo_etapa')
                ->references('id')->on('pa_etapa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pa_arquivo');
    }
};
