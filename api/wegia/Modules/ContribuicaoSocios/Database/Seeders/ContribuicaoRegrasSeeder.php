<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoRegras;

class ContribuicaoRegrasSeeder extends Seeder
{
    public function run(): void
    {
        $regras = [
            [1, 'MIN_VALUE'],
            [2, 'MAX_VALUE']
        ];

        foreach ($regras as [$id, $regra]) {
            ContribuicaoRegras::firstOrCreate(
                ['id' => $id],
                ['regra' => $regra]
            );
        }
    }
}
