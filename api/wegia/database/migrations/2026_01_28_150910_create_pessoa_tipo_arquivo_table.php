<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pessoa_tipo_arquivo', function (Blueprint $table) {
            $table->increments('id_pessoa_tipo_arquivo');
            $table->string('descricao', 255)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoa_tipo_arquivo');
    }
};
