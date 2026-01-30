<?php

namespace Database\Seeders;

use App\Models\Funcionario\Funcionario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        Funcionario::firstOrCreate(
            ['id_funcionario' => 1],
            [
                'id_pessoa' => 1,
                'id_perfil' => 1,
                'id_situacao' => 1,
                'data_admissao' => '2020-06-03',
                'pis' => null,
                'ctps' => '',
                'uf_ctps' => null,
                'numero_titulo' => null,
                'zona' => null,
                'secao' => null,
                'certificado_reservista_numero' => null,
                'certificado_reservista_serie' => null
            ]
        );
    }
}
