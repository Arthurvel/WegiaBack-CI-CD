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
        Schema::create('pet_exame', function (Blueprint $table) {
            $table->id('id_exame');

            $table->foreignId('id_ficha_medica')
                ->constrained('pet_ficha_medica', 'id_ficha_medica');

            $table->foreignId('id_tipo_exame')
                ->constrained('pet_tipo_exame', 'id_tipo_exame');

            $table->date('data_exame');
            $table->string('arquivo_exame', 255);
            $table->string('arquivo_nome', 200);
            $table->string('arquivo_extensao', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_exame');
    }
};
