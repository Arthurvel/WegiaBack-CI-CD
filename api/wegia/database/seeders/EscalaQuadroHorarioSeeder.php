<?php

namespace Database\Seeders;

use App\Models\Funcionario\FuncionarioQuadroHorarioEscala;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscalaQuadroHorarioSeeder extends Seeder
{
    public function run(): void
    {
        $escalas = [
            '5x2 - 5 dias trabalhados com 2 dias de folga',
            '12x36 - 12 horas trabalhadas com 36 horas de folga',
        ];

        foreach ($escalas as $desc) {
            FuncionarioQuadroHorarioEscala::firstOrCreate(
                ['descricao' => $desc]
            );
        }
    }
}
