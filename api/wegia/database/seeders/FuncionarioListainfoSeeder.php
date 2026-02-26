<?php

namespace Database\Seeders;

use App\Models\Funcionario\FuncionarioListaInfo;
use Illuminate\Database\Seeder;

class FuncionarioListainfoSeeder extends Seeder
{
    public function run(): void
    {
        $lista = [
            ['idfuncionario_listainfo' => 1, 'descricao' => 'Escolaridade'],
            ['idfuncionario_listainfo' => 2, 'descricao' => 'Naturalidade'],
            ['idfuncionario_listainfo' => 3, 'descricao' => 'Estado Civil'],
            ['idfuncionario_listainfo' => 4, 'descricao' => 'Carteira do SUS'],
        ];

        foreach ($lista as $l) {
            FuncionarioListaInfo::firstOrCreate(
                ['idfuncionario_listainfo' => $l['idfuncionario_listainfo']],
                ['descricao' => $l['descricao']]
            );
        }
    }
}
