<?php

namespace Modules\Material\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Material\app\Models\Parceiro;

class MaterialParceiroSeeder extends Seeder
{
    public function run(): void
    {
        Parceiro::updateOrCreate(
            ['id_parceiro' => 1],
            ['nome' => 'Doador não identificado']
        );
    }
}
