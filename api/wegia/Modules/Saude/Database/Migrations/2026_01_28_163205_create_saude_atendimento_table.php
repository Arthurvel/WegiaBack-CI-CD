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
        Schema::create('saude_atendimento', function (Blueprint $table) {
            $table->id('id_atendimento');

            $table->foreignId('id_fichamedica')
                ->constrained('saude_fichamedica', 'id_fichamedica');

            $table->unsignedInteger('id_funcionario');

            $table->foreignId('id_medico')
                ->constrained('saude_medicos', 'id_medico');

            $table->date('data_registro')->useCurrent();
            $table->date('data_atendimento')->nullable();
            $table->text('descricao')->nullable();

            $table->foreign('id_funcionario')
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
        Schema::dropIfExists('saude_atendimento');
    }
};
