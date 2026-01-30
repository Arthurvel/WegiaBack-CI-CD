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
        Schema::create('material_produto', function (Blueprint $table) {
            $table->id('id_produto');

            $table->foreignId('id_categoria')
                ->constrained('material_categoria', 'id_categoria');

            $table->foreignId('id_unidade')
                ->constrained('material_unidade', 'id_unidade');

            $table->string('descricao', 150)->unique();
            $table->string('codigo', 15)->nullable()->unique();
            $table->boolean('oculto')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_produto');
    }
};
