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
        Schema::create('material_transacao_produto_logs', function (Blueprint $table) {
            $table->id('id_transacao_produto_log');

            $table->integer('id_transacao_produto');
            $table->integer('id_transacao');
            $table->integer('id_produto');

            $table->integer('quantidade');
            $table->decimal('valor_unitario', 10, 2);

            $table->unsignedInteger('id_usuario_acao');

            $table->enum('acao', ['create', 'update', 'delete']);
            $table->dateTime('data_acao')->useCurrent();

            $table->foreign('id_usuario_acao')
                ->references('id_pessoa')
                ->on('pessoa')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_transacao_produto_logs');
    }
};
