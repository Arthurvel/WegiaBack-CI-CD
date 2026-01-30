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
        Schema::create('atendido_ocorrencia_tipos', function (Blueprint $table) {
            $table->increments('idatendido_ocorrencia_tipos');
            $table->string('descricao', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendido_ocorrencia_tipos');
    }
};
