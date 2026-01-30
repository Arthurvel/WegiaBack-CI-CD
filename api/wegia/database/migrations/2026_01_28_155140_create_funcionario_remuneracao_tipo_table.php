<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionario_remuneracao_tipo', function (Blueprint $table) {
            $table->increments('idfuncionario_remuneracao_tipo');
            $table->string('descricao', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionario_remuneracao_tipo');
    }
};
