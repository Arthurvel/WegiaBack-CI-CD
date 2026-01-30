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
        Schema::create('contribuicao_conjuntoRegras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_meioPagamento')
                ->nullable()
                ->constrained('contribuicao_meioPagamento');

            $table->foreignId('id_regra')
                ->nullable()
                ->constrained('contribuicao_regras');

            $table->decimal('valor', 10, 2)->nullable();
            $table->boolean('status');

            $table->unique(['id_meioPagamento', 'id_regra'], 'unico_meioPagamento_regra');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuicao_conjuntoRegras');
    }
};
