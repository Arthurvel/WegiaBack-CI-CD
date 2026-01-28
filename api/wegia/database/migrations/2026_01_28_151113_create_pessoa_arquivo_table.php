<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pessoa_arquivo', function (Blueprint $table) {
            $table->increments('id_pessoa_arquivo');

            $table->unsignedInteger('id_pessoa');
            $table->unsignedInteger('id_pessoa_tipo_arquivo');

            $table->dateTime('data')->useCurrent();
            $table->string('extensao_arquivo', 10);
            $table->string('nome_arquivo', 255);
            $table->string('arquivo', 255);

            $table->foreign('id_pessoa', 'fk_pessoa_arquivo_pessoa')
                ->references('id_pessoa')
                ->on('pessoa')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_pessoa_tipo_arquivo', 'fk_pessoa_arquivo_tipo')
                ->references('id_pessoa_tipo_arquivo')
                ->on('pessoa_tipo_arquivo')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoa_arquivo');
    }
};
