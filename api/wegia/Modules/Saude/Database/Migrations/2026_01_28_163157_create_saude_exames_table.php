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
        Schema::create('saude_exames', function (Blueprint $table) {
            $table->id('id_exame');

            $table->foreignId('id_fichamedica')
                ->constrained('saude_fichamedica', 'id_fichamedica');

            $table->foreignId('id_exame_tipo')
                ->constrained('saude_exame_tipos', 'id_exame_tipo');

            $table->timestamp('data');
            $table->string('arquivo_nome', 255);
            $table->string('arquivo_extensao', 10)->nullable();
            $table->string('arquivo', 100);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saude_exames');
    }
};
