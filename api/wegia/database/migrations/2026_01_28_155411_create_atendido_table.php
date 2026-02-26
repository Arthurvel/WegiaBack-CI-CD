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
        Schema::create('atendido', function (Blueprint $table) {
            $table->increments('idatendido');

            $table->unsignedInteger('pessoa_id_pessoa');
            $table->unsignedInteger('atendido_tipo_idatendido_tipo');
            $table->unsignedInteger('atendido_status_idatendido_status');

            $table->index('pessoa_id_pessoa', 'fk_atendido_pessoa1_idx');
            $table->index('atendido_tipo_idatendido_tipo', 'fk_atendido_atendido_tipo1_idx');
            $table->index('atendido_status_idatendido_status', 'fk_atendido_atentido_status1_idx');

            $table->foreign('pessoa_id_pessoa', 'fk_atendido_pessoa1')
                ->references('id_pessoa')->on('pessoa');

            $table->foreign('atendido_tipo_idatendido_tipo', 'fk_atendido_atendido_tipo1')
                ->references('idatendido_tipo')->on('atendido_tipo');

            $table->foreign('atendido_status_idatendido_status', 'fk_atendido_atentido_status1')
                ->references('idatendido_status')->on('atendido_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendido');
    }
};
