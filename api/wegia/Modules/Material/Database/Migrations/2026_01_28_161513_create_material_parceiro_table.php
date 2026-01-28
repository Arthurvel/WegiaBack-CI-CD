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
        Schema::create('material_parceiro', function (Blueprint $table) {
            $table->id('id_parceiro');
            $table->string('nome', 100);
            $table->string('cpf', 14)->nullable();
            $table->string('cnpj', 18)->nullable();
            $table->string('telefone', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_parceiro');
    }
};
