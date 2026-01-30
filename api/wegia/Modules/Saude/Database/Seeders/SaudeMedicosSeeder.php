<?php

namespace Modules\Saude\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Saude\app\Models\SaudeMedico;

class SaudeMedicosSeeder extends Seeder
{
    public function run(): void
    {
        SaudeMedico::updateOrCreate(
            ['id_medico' => 1],
            [
                'crm'  => '123456/RJ',
                'nome' => 'Sem médico definido'
            ]
        );
    }
}
