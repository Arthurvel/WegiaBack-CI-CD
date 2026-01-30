<?php

namespace Database\Seeders;

use App\Models\Atendido\OcorrenciaTipos;
use Illuminate\Database\Seeder;

class AtendidoOcorrenciaTiposSeeder extends Seeder
{

    public function run(): void
    {
        $tipos = [
            ['idatendido_ocorrencia_tipos' => 1, 'descricao' => 'Acolhimento'],
            ['idatendido_ocorrencia_tipos' => 2, 'descricao' => 'Falecimento'],
        ];

        foreach ($tipos as $t) {
            OcorrenciaTipos::firstOrCreate(
                ['idatendido_ocorrencia_tipos' => $t['idatendido_ocorrencia_tipos']],
                ['descricao' => $t['descricao']]
            );
        }
    }

}
