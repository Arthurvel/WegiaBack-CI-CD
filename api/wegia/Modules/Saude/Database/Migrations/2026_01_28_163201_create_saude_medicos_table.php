<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saude_medicos', function (Blueprint $table) {
            $table->id('id_medico');
            $table->char('crm', 10)->nullable();
            $table->string('nome', 50)->nullable();

            $table->unique(['crm', 'nome']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_medicos');
    }
};
