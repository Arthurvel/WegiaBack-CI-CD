<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfil_permissao', function (Blueprint $table) {
            $table->unsignedInteger('id_perfil');
            $table->unsignedInteger('id_permissao');

            $table->primary(['id_perfil', 'id_permissao']);

            $table->foreign('id_perfil', 'fk_perfil')
                ->references('id_perfil')
                ->on('perfil')
                ->onDelete('cascade');

            $table->foreign('id_permissao', 'fk_permissao')
                ->references('id_permissao')
                ->on('permissao')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfil_permissao');
    }
};
