<?php

namespace Database\Seeders;

use app\Models\Configuracao\ContatoInstituicao;
use Illuminate\Database\Seeder;

class ContatoInstituicaoSeeder extends Seeder
{
    public function run(): void
    {
        ContatoInstituicao::firstOrCreate(
            ['id' => 1],
            [
                'descricao' => 'Apoio aos doadores',
                'contato' => 'telefone_ou_@email.com'
            ]
        );
    }
}
