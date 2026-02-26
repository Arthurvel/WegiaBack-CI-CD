<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('despacho', function (Blueprint $table) {
            $table->id('id_despacho');

            $table->foreignId('id_memorando')
                ->constrained('memorando', 'id_memorando');

            $table->unsignedInteger('id_remetente');

            $table->unsignedInteger('id_destinatario');

            $table->longText('texto')->nullable();

            $table->timestamp('data')
                ->useCurrent()
                ->useCurrentOnUpdate();

            $table->foreign('id_remetente')
                ->references('id_pessoa')
                ->on('pessoa')
                ->onDelete('cascade');

            $table->foreign('id_destinatario')
                ->references('id_pessoa')
                ->on('pessoa')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despacho');
    }
};
