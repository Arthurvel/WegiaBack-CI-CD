<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;

class ContribuicaoMeioPagamentoSeeder extends Seeder
{
    public function run(): void
    {
        $meios = [
            ['meio' => 'Boleto', 'id_plataforma' => 1, 'status' => 0],
            ['meio' => 'Pix', 'id_plataforma' => 1, 'status' => 0],
            ['meio' => 'Carne', 'id_plataforma' => 1, 'status' => 0],
            ['meio' => 'CartaoCredito', 'id_plataforma' => 1, 'status' => 0],
            ['meio' => 'Recorrencia', 'id_plataforma' => 1, 'status' => 0],
        ];

        foreach ($meios as $m) {
            ContribuicaoMeioDePagamento::firstOrCreate(
                ['meio' => $m['meio']],
                ['id_plataforma' => $m['id_plataforma'], 'status' => $m['status']]
            );
        }
    }
}
