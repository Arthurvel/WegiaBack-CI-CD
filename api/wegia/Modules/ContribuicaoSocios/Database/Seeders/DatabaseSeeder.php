<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ContribuicaoRegrasSeeder::class,
            ContribuicaoGatewayPagamentoSeeder::class,
            ContribuicaoMeioPagamentoSeeder::class,
            ContribuicaoConjuntoRegrasSeeder::class,
            SocioStatusSeeder::class,
            SocioTagSeeder::class,
            SocioTipoSeeder::class
        ]);
    }
}
