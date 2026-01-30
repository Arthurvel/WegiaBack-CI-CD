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
        Schema::create('material_transacao_produto', function (Blueprint $table) {
            $table->id('id_transacao_produto');

            $table->foreignId('id_transacao')
                ->constrained('material_transacao', 'id_transacao')
                ->cascadeOnDelete();

            $table->foreignId('id_produto')
                ->constrained('material_produto', 'id_produto');

            $table->integer('quantidade');
            $table->decimal('valor_unitario', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_transacao_produto');
    }
};
