<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('selecao_paragrafo', function (Blueprint $table) {
            $table->id('id_selecao');
            $table->string('nome_campo', 40);
            $table->text('paragrafo');
            $table->boolean('original')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('selecao_paragrafo');
    }
};
