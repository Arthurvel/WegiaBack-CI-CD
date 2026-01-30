<?php

namespace Database\Seeders;

use App\Models\Funcionario\FuncionarioQuadroHorarioTipo;
use Illuminate\Database\Seeder;

class TipoQuadroHorarioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['id_tipo' => 1, 'descricao' => 'Segunda à Sexta, folga Sábado e Domingo'],
            ['id_tipo' => 2, 'descricao' => 'Dias alternados'],
        ];

        foreach ($tipos as $t) {
            FuncionarioQuadroHorarioTipo::firstOrCreate(
                ['id_tipo' => $t['id_tipo']],
                ['descricao' => $t['descricao']]
            );
        }
    }
}
