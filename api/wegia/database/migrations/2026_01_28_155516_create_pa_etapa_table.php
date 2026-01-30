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
        Schema::create('pa_etapa', function (Blueprint $table) {
            $table->increments('id');

            $table->dateTime('data_inicio');
            $table->dateTime('data_fim')->nullable();
            $table->string('descricao', 512);

            $table->unsignedInteger('id_processo');
            $table->unsignedInteger('id_status');

            $table->foreign('id_processo', 'fk_etapa_processo')
                ->references('id')->on('processo_de_aceitacao');

            $table->foreign('id_status', 'fk_etapa_status')
                ->references('id')->on('pa_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pa_etapa');
    }
};
