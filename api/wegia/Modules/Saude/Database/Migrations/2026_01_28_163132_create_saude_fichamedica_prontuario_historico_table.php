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
        Schema::create('saude_fichamedica_prontuario_historico', function (Blueprint $table) {
            $table->id('id_prontuario_historico');

            $table->foreignId('id_fichamedica')
                ->constrained('saude_fichamedica', 'id_fichamedica')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->text('prontuario');
            $table->dateTime('data')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_fichamedica_prontuario_historico');
    }
};
