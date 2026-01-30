<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pessoa_dependente', function (Blueprint $table) {
            $table->increments('id_dependente');

            $table->unsignedInteger('id_pessoa');
            $table->unsignedInteger('id_dependente_pessoa');

            $table->enum('parentesco', [
                'Companheiro(a)',
                'Cônjuge',
                'Enteado(a)',
                'Ex-cônjuge',
                'Filho(a)',
                'Irmão(ã)',
                'Neto(a)',
                'Pais',
                'Outra relação de dependência'
            ]);

            $table->foreign('id_pessoa', 'fk_dependente_pessoa')
                ->references('id_pessoa')
                ->on('pessoa');

            $table->foreign('id_dependente_pessoa', 'fk_dependente_pessoa_dependente')
                ->references('id_pessoa')
                ->on('pessoa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoa_dependente');
    }
};
