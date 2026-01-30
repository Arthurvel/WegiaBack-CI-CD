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
        Schema::create('socio', function (Blueprint $table) {
            $table->increments('id_socio');

            $table->unsignedInteger('id_pessoa');
            $table->unsignedInteger('id_sociostatus');
            $table->unsignedInteger('id_sociotipo');
            $table->unsignedInteger('id_sociotag')->nullable();

            $table->string('email', 256)->nullable();
            $table->decimal('valor_periodo', 10, 2)->nullable();
            $table->date('data_referencia')->nullable();

            $table->unique('id_pessoa');

            $table->foreign('id_pessoa')
                ->references('id_pessoa')
                ->on('pessoa')
                ->onDelete('cascade');

            $table->foreign('id_sociostatus')
                ->references('id_sociostatus')
                ->on('socio_status');

            $table->foreign('id_sociotipo')
                ->references('id_sociotipo')
                ->on('socio_tipo');

            $table->foreign('id_sociotag')
                ->references('id_sociotag')
                ->on('socio_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socio');
    }
};
