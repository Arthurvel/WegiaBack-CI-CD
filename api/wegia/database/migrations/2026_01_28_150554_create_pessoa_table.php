<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pessoa', function (Blueprint $table) {
            $table->increments('id_pessoa');

            $table->string('cpf', 120)->nullable()->unique();
            $table->string('senha', 70)->nullable();
            $table->string('nome', 100)->nullable();
            $table->string('sobrenome', 100)->nullable();
            $table->char('sexo', 1)->nullable();
            $table->string('telefone', 25)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->longText('imagem')->nullable();

            $table->string('cep', 10)->nullable();
            $table->string('estado', 5)->nullable();
            $table->string('cidade', 40)->nullable();
            $table->string('bairro', 40)->nullable();
            $table->string('logradouro', 100)->nullable();
            $table->string('numero_endereco', 80)->nullable();
            $table->string('complemento', 50)->nullable();
            $table->string('ibge', 20)->nullable();

            $table->string('registro_geral', 120)->nullable();
            $table->string('orgao_emissor', 120)->nullable();
            $table->date('data_expedicao')->nullable();

            $table->string('nome_mae', 100)->nullable();
            $table->string('nome_pai', 100)->nullable();
            $table->string('tipo_sanguineo', 5)->nullable();

            $table->tinyInteger('nivel_acesso')->default(0);
            $table->tinyInteger('adm_configurado')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoa');
    }
};

