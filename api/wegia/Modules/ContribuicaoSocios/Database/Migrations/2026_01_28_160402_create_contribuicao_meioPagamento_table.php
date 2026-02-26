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
        Schema::create('contribuicao_meioPagamento', function (Blueprint $table) {
            $table->id();
            $table->string('meio', 45)->unique();
            $table->foreignId('id_plataforma')
                ->constrained('contribuicao_gatewayPagamento')
                ->restrictOnDelete();
            $table->boolean('status');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuicao_meioPagamento');
    }
};
