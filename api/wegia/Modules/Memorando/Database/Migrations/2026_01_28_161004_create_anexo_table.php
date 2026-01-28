<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anexo', function (Blueprint $table) {
            $table->id('id_anexo');

            $table->foreignId('id_despacho')
                ->constrained('despacho', 'id_despacho');

            $table->string('anexo', 255);
            $table->string('extensao', 256);
            $table->string('nome', 256);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anexo');
    }
};
