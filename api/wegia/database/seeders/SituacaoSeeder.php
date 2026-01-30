<?php

namespace Database\Seeders;

use App\Models\Situacao;
use Illuminate\Database\Seeder;

class SituacaoSeeder extends Seeder
{
    public function run(): void
    {
        $situacoes = [
            ['id_situacao' => 1, 'situacoes' => 'Ativo'],
            ['id_situacao' => 2, 'situacoes' => 'Inativo'],
        ];

        foreach ($situacoes as $s) {
            Situacao::firstOrCreate(
                ['id_situacao' => $s['id_situacao']],
                ['situacoes' => $s['situacoes']]
            );
        }
    }
}
