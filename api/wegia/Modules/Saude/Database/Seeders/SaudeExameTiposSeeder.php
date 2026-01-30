<?php

namespace Modules\Saude\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Saude\app\Models\SaudeExameTipos;

class SaudeExameTiposSeeder extends Seeder
{
    public function run(): void
    {
        $exames = [
            [1, 'Fezes'],
            [2, 'Hemograma'],
            [3, 'Urina'],
            [4, 'Cardíaco'],
            [5, 'Glicemia'],
            [6, 'Colesterol'],
            [7, 'TSH'],
            [8, 'Papanicolau'],
            [9, 'Transaminases'],
            [10, 'Creatinina'],
            [11, 'Triglicerídios'],
            [12, 'Ácido úrico'],
            [13, 'Ureia'],
            [14, 'TGO'],
            [15, 'TGP'],
        ];

        foreach ($exames as [$id, $descricao]) {
            SaudeExameTipos::updateOrCreate(
                ['id_exame_tipo' => $id],
                ['descricao' => $descricao]
            );
        }
    }
}
