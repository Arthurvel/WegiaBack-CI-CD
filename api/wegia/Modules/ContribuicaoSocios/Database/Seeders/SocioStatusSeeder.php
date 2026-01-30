<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\SocioStatus;

class SocioStatusSeeder extends Seeder
{
    public function run(): void
    {
        $status = [
            [0, 'Ativo'],
            [1, 'Inativo'],
            [2, 'Inadimplente'],
            [3, 'Inativo Temporariamente'],
            [4, 'Sem informação'],
        ];

        foreach ($status as [$id, $nome]) {
            SocioStatus::firstOrCreate(
                ['id_sociostatus' => $id],
                ['status' => $nome]
            );
        }
    }
}
