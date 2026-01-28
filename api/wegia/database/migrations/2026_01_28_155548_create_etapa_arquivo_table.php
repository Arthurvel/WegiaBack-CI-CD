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
        Schema::create('etapa_arquivo', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('etapa_id');

            $table->string('arquivo_nome', 255);
            $table->string('arquivo_extensao', 10);
            $table->string('arquivo', 255);
            $table->dateTime('data_upload')->useCurrent();

            $table->foreign('etapa_id', 'fk_etapa_arquivo_etapa')
                ->references('id')->on('pa_etapa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapa_arquivo');
    }
};
