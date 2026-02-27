<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AtendidoOcorrenciaTiposSeeder::class,
            AtendidoStatusSeeder::class,
            AtendidoTipoSeeder::class,
            CampoImagemSeeder::class,
            ContatoInstituicaoSeeder::class,
            EscalaQuadroHorarioSeeder::class,
            FuncionarioListainfoSeeder::class,
            FuncionarioRemuneracaoTipoSeeder::class,
            PaStatusSeeder::class,
            PerfilSeeder::class,
            PermissaoSeeder::class,
            PessoaSeeder::class,
            PerfilPermissaoSeeder::class,
            SelecaoParagrafoSeeder::class,
            SituacaoSeeder::class,
            TipoQuadroHorarioSeeder::class,
            FuncionarioSeeder::class
        ]);
    }
}
