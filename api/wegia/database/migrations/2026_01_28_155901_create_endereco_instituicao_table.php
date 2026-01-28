<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('endereco_instituicao', function (Blueprint $table) {
            $table->id('id_inst');
            $table->string('nome', 256);
            $table->string('numero_endereco', 256);
            $table->string('logradouro', 256);
            $table->string('bairro', 256)->nullable();
            $table->string('cidade', 256);
            $table->string('estado', 256);
            $table->string('cep', 256);
            $table->string('complemento', 256)->nullable();
            $table->string('ibge', 256);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('endereco_instituicao');
    }
};
