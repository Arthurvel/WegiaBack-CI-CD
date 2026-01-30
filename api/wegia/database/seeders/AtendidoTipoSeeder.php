<?php

namespace Database\Seeders;

use App\Models\Atendido\AtendidoTipo;
use Illuminate\Database\Seeder;

class AtendidoTipoSeeder extends Seeder
{
    public function run(): void
    {
        AtendidoTipo::firstOrCreate(
            ['idatendido_tipo' => 1],
            ['descricao' => 'Interno']
        );
    }
}
