<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoGatewayPagamento;

class ContribuicaoGatewayPagamentoSeeder extends Seeder
{
    public function run(): void
    {
        ContribuicaoGatewayPagamento::firstOrCreate(
            ['id' => 1],
            ['plataforma' => 'PagarMe']
        );
    }
}
