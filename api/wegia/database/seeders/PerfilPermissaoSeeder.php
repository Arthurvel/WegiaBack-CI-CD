<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilPermissaoSeeder extends Seeder
{
    public function run(): void
    {
        $permissoes = DB::table('permissao')->pluck('id_permissao');

        foreach ($permissoes as $id) {
            DB::table('perfil_permissao')->updateOrInsert(
                [
                    'id_perfil' => 1,
                    'id_permissao' => $id
                ]
            );
        }
    }
}
