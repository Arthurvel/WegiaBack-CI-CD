<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contato_instituicao', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 256);
            $table->string('contato', 256);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contato_instituicao');
    }
};
