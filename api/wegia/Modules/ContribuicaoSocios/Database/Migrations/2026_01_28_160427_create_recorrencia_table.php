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
        Schema::create('recorrencia', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('id_socio');


            $table->foreignId('id_gateway')
                ->constrained('contribuicao_gatewayPagamento');

            $table->string('codigo', 255)->unique();
            $table->decimal('valor', 10, 2);
            $table->date('data_inicio');
            $table->date('data_termino')->nullable();
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('recorrencia');
    }
};
