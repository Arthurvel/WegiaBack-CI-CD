<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memorando', function (Blueprint $table) {
            $table->id('id_memorando');

            $table->unsignedInteger('id_pessoa');

            $table->enum('status_memorando', [
                'Ativo', 'Lido', 'Não Lido', 'Importante', 'Pendente', 'Arquivado'
            ])->default('Pendente');

            $table->text('titulo')->nullable();

            $table->timestamp('data')
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->foreign('id_pessoa')
                ->references('id_pessoa')
                ->on('pessoa')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memorando');
    }
};
