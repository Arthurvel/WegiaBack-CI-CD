<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id_funcionario');

            $table->unsignedInteger('id_pessoa');
            $table->unsignedInteger('id_perfil');
            $table->unsignedInteger('id_situacao');

            $table->date('data_admissao');

            $table->string('pis', 140)->nullable();
            $table->string('ctps', 150);
            $table->string('uf_ctps', 20)->nullable();
            $table->string('numero_titulo', 150)->nullable();
            $table->string('zona', 30)->nullable();
            $table->string('secao', 40)->nullable();
            $table->string('certificado_reservista_numero', 100)->nullable();
            $table->string('certificado_reservista_serie', 100)->nullable();

            // Índices
            $table->index('id_pessoa');
            $table->index('id_perfil', 'fk_funcionario_perfil1_idx');
            $table->index('id_situacao', 'fk_funcionario_situacao1_idx');

            // Foreign Keys
            $table->foreign('id_pessoa', 'funcionario_ibfk_1')
                ->references('id_pessoa')
                ->on('pessoa');

            $table->foreign('id_perfil', 'fk_funcionario_perfil1')
                ->references('id_perfil')
                ->on('perfil')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_situacao', 'fk_funcionario_situacao1')
                ->references('id_situacao')
                ->on('situacao')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionario');
    }
};
