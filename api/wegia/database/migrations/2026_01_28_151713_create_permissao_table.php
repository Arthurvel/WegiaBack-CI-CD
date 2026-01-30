<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissao', function (Blueprint $table) {
            $table->increments('id_permissao');
            $table->string('nome', 100);
            $table->enum('categoria', [
                'Pessoa',
                'Pet',
                'Material',
                'Memorando',
                'Socios',
                'Saude',
                'Contribuição',
                'Configuração'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissao');
    }
};
