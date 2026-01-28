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
        Schema::create('material_transacao', function (Blueprint $table) {
            $table->id('id_transacao');

            $table->foreignId('id_tipo_movimentacao')
                ->constrained('material_tipo_movimentacao', 'id_tipo_movimentacao');

            $table->foreignId('id_almoxarifado')
                ->constrained('material_almoxarifado', 'id_almoxarifado');

            $table->unsignedInteger('id_responsavel');

            $table->foreignId('id_parceiro')
                ->constrained('material_parceiro', 'id_parceiro');

            $table->dateTime('data')->useCurrent();

            $table->foreign('id_responsavel')
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
        Schema::dropIfExists('material_transacao');
    }
};
