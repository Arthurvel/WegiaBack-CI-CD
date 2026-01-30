<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aviso', function (Blueprint $table) {
            $table->increments('id_aviso');

            $table->unsignedInteger('id_pessoa');

            $table->string('titulo', 255);
            $table->text('descricao');

            $table->dateTime('data_criacao')
                ->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->enum('nivel', ['info', 'alerta', 'erro'])
                ->default('info');

            $table->string('url', 100)->nullable();
            $table->boolean('ativo')->default(true);

            $table->foreign('id_pessoa')
                ->references('id_pessoa')
                ->on('pessoa')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aviso');
    }
};
