<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionario_listainfo', function (Blueprint $table) {
            $table->increments('idfuncionario_listainfo');
            $table->string('descricao', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionario_listainfo');
    }
};
