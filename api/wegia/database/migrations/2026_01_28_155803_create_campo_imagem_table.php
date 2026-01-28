<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campo_imagem', function (Blueprint $table) {
            $table->id('id_campo');
            $table->string('nome_campo', 40)->unique();
            $table->enum('tipo', ['img', 'car']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campo_imagem');
    }
};

