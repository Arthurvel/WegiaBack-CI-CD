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
        Schema::create('contribuicao_log', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('id_socio');

            $table->foreignId('id_gateway')
                ->constrained('contribuicao_gatewayPagamento');

            $table->foreignId('id_meio_pagamento')
                ->constrained('contribuicao_meioPagamento');

            $table->foreignId('id_recorrencia')
                ->nullable()
                ->constrained('recorrencia');

            $table->string('codigo', 255)->unique();
            $table->decimal('valor', 10, 2);
            $table->date('data_geracao');
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->boolean('status_pagamento');
            $table->longText('url')->nullable();

            $table->foreign('id_socio')
                ->references('id_socio')
                ->on('socio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuicao_log');
    }
};
