<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoConjuntoRegras;

class ContribuicaoConjuntoRegrasSeeder extends Seeder
{
    public function run(): void
    {
        $conjuntos = [
            ['id_meioPagamento' => 1, 'id_regra' => 1, 'valor' => 1, 'status' => 0],
            ['id_meioPagamento' => 1, 'id_regra' => 2, 'valor' => 1000, 'status' => 0],
            ['id_meioPagamento' => 2, 'id_regra' => 1, 'valor' => 1, 'status' => 0],
            ['id_meioPagamento' => 2, 'id_regra' => 2, 'valor' => 1000, 'status' => 0],
            ['id_meioPagamento' => 3, 'id_regra' => 1, 'valor' => 1, 'status' => 0],
            ['id_meioPagamento' => 3, 'id_regra' => 2, 'valor' => 1000, 'status' => 0],
        ];

        foreach ($conjuntos as $c) {
            ContribuicaoConjuntoRegras::firstOrCreate(
                [
                    'id_meioPagamento' => $c['id_meioPagamento'],
                    'id_regra' => $c['id_regra']
                ],
                [
                    'valor' => $c['valor'],
                    'status' => $c['status']
                ]
            );
        }
    }
}
