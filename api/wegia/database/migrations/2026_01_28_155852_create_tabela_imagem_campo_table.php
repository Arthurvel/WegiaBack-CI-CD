<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tabela_imagem_campo', function (Blueprint $table) {
            $table->id('id_relacao');

            $table->foreignId('id_campo')
                ->constrained('campo_imagem', 'id_campo')
                ->cascadeOnDelete();

            $table->foreignId('id_imagem')
                ->constrained('imagem', 'id_imagem')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabela_imagem_campo');
    }
};

