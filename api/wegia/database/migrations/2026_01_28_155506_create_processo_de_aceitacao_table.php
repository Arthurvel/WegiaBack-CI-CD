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
        Schema::create('processo_de_aceitacao', function (Blueprint $table) {
            $table->increments('id');

            $table->dateTime('data_inicio');
            $table->dateTime('data_fim')->nullable();
            $table->text('descricao');

            $table->unsignedInteger('id_status');
            $table->unsignedInteger('id_pessoa');

            $table->foreign('id_status', 'fk_processo_status')
                ->references('id')->on('pa_status');

            $table->foreign('id_pessoa', 'fk_processo_pessoa')
                ->references('id_pessoa')->on('pessoa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processo_de_aceitacao');
    }
};
