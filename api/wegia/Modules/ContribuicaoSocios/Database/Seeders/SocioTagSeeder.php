<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\SocioTag;

class SocioTagSeeder extends Seeder
{
    public function run(): void
    {
        SocioTag::firstOrCreate(
            ['id_sociotag' => 1],
            ['tag' => 'Solicitante']
        );
    }
}
