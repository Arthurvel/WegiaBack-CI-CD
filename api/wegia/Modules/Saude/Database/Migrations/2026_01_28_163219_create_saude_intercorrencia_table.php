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
        Schema::create('saude_intercorrencia', function (Blueprint $table) {
            $table->id('id_intercorrencia');

            $table->dateTime('data')->useCurrent();
            $table->text('descricao');

            $table->unsignedInteger('id_funcionario');

            $table->foreignId('id_fichamedica')
                ->constrained('saude_fichamedica', 'id_fichamedica')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_funcionario')
                ->references('id_funcionario')
                ->on('funcionario')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_intercorrencia');
    }
};
