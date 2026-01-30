<?php

namespace Database\Seeders;

use App\Models\Funcionario\FuncionarioRemuneracaoTipo;
use Illuminate\Database\Seeder;

class FuncionarioRemuneracaoTipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['idfuncionario_remuneracao_tipo' => 1, 'descricao' => 'Vencimento Básico'],
            ['idfuncionario_remuneracao_tipo' => 2, 'descricao' => 'Vale-alimentação'],
            ['idfuncionario_remuneracao_tipo' => 3, 'descricao' => 'Salário Família'],
            ['idfuncionario_remuneracao_tipo' => 4, 'descricao' => 'Adicional Noturno'],
            ['idfuncionario_remuneracao_tipo' => 5, 'descricao' => 'Insalubridade'],
            ['idfuncionario_remuneracao_tipo' => 6, 'descricao' => 'Periculosidade'],
            ['idfuncionario_remuneracao_tipo' => 7, 'descricao' => 'Vale transporte'],
        ];

        foreach ($tipos as $t) {
            FuncionarioRemuneracaoTipo::firstOrCreate(
                ['idfuncionario_remuneracao_tipo' => $t['idfuncionario_remuneracao_tipo']],
                ['descricao' => $t['descricao']]
            );
        }
    }
}
