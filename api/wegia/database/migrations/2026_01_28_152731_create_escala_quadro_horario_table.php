<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escala_quadro_horario', function (Blueprint $table) {
            $table->increments('id_escala');
            $table->string('descricao', 200);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escala_quadro_horario');
    }
};
