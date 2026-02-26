<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\SocioStatus;

class SocioStatusSeeder extends Seeder
{
    public function run(): void
    {
        $status = [
            [1, 'Ativo'],
            [2, 'Inativo'],
            [3, 'Inadimplente'],
            [4, 'Inativo Temporariamente'],
            [5, 'Sem informação'],
        ];

        foreach ($status as [$id, $nome]) {
            SocioStatus::firstOrCreate(
                ['id_sociostatus' => $id],
                ['status' => $nome]
            );
        }
    }
}
