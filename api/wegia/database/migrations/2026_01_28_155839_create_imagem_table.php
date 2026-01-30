<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('imagem', function (Blueprint $table) {
            $table->id('id_imagem');
            $table->string('nome', 50)->unique();
            $table->longText('imagem')->nullable();
            $table->string('tipo', 25);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagem');
    }
};

