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
        Schema::create('saude_sinais_vitais', function (Blueprint $table) {
            $table->id('id_sinais_vitais');

            $table->foreignId('id_fichamedica')
                ->constrained('saude_fichamedica', 'id_fichamedica');

            $table->unsignedInteger('id_funcionario');

            $table->timestamp('data');

            $table->decimal('saturacao', 5, 2)->nullable();
            $table->string('pressao_arterial', 10)->nullable();
            $table->integer('frequencia_cardiaca')->nullable();
            $table->integer('frequencia_respiratoria')->nullable();
            $table->decimal('temperatura', 7, 2)->nullable();
            $table->decimal('hgt', 7, 2)->nullable();

            $table->foreign('id_funcionario')
                ->references('id_funcionario')
                ->on('funcionario')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_sinais_vitais');
    }
};
