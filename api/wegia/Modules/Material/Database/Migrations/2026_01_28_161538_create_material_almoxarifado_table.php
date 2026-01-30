<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_almoxarifado', function (Blueprint $table) {
            $table->id('id_almoxarifado');
            $table->string('descricao', 240);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_almoxarifado');
    }
};
