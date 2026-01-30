<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder{

    public function run(): void
    {
        $perfis = [
            ['id_perfil'=>1,'cargo'=>'Administrador','nome'=>'Administrador'],
            ['id_perfil'=>2,'cargo'=>'Sem cargo definido','nome'=>'Sem cargo definido'],
        ];

        foreach ($perfis as $perfil) {
            DB::table('perfil')->updateOrInsert(
                ['id_perfil' => $perfil['id_perfil']],
                ['cargo' => $perfil['cargo'], 'nome' => $perfil['nome']]
            );
        }
    }
}
