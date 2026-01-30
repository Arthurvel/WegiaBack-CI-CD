<?php

namespace Database\Seeders;

use app\Models\Configuracao\CampoImagem;
use Illuminate\Database\Seeder;

class CampoImagemSeeder extends Seeder
{
    public function run(): void
    {
        CampoImagem::firstOrCreate(
            ['id_campo' => 1],
            ['nome_campo' => 'Logo', 'tipo' => 'img']
        );

        CampoImagem::firstOrCreate(
            ['id_campo' => 2],
            ['nome_campo' => 'Carrossel', 'tipo' => 'car']
        );
    }
}
