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
        Schema::create('saude_fichamedica_alergia', function (Blueprint $table) {
            $table->id('id_fichamedica_alergia');

            $table->foreignId('id_fichamedica')
                ->constrained('saude_fichamedica', 'id_fichamedica')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('id_alergia')
                ->constrained('saude_alergia', 'id_alergia')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unique(['id_fichamedica', 'id_alergia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_fichamedica_alergia');
    }
};
