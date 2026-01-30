<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->increments('id_perfil');
            $table->string('cargo', 100);
            $table->string('nome', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfil');
    }
};
