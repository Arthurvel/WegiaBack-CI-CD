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
        Schema::create('pet_medicacao', function (Blueprint $table) {
            $table->id('id_medicacao');

            $table->foreignId('id_medicamento')
                ->constrained('pet_medicamento', 'id_medicamento');

            $table->foreignId('id_pet_atendimento')
                ->constrained('pet_atendimento', 'id_pet_atendimento');

            $table->date('data_medicacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_medicacao');
    }
};
