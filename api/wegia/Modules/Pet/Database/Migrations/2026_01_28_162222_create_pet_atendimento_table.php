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
        Schema::create('pet_atendimento', function (Blueprint $table) {
            $table->id('id_pet_atendimento');

            $table->foreignId('id_ficha_medica')
                ->constrained('pet_ficha_medica', 'id_ficha_medica');

            $table->date('data_atendimento');
            $table->text('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_atendimento');
    }
};
