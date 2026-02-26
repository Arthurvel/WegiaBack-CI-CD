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
        Schema::create('material_tipo_movimentacao', function (Blueprint $table) {
            $table->id('id_tipo_movimentacao');
            $table->string('nome', 100);
            $table->enum('tipo', ['e', 's']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_tipo_movimentacao');
    }
};
