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
        Schema::create('pet_adocao', function (Blueprint $table) {
            $table->id('id_adocao');

            $table->unsignedInteger('id_pessoa');

            $table->foreignId('id_pet')
                ->constrained('pet', 'id_pet');

            $table->date('data_adocao');

            $table->foreign('id_pessoa')
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
        Schema::dropIfExists('pet_adocao');
    }
};
