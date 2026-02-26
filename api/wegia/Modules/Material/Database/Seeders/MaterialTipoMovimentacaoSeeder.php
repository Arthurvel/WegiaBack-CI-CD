<?php

namespace Modules\Material\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Material\app\Models\TipoMovimentacao;

class MaterialTipoMovimentacaoSeeder extends Seeder
{
    public function run(): void
    {
        $movimentacoes = [
            [1, 'Doação', 'e'],
            [2, 'Compra', 'e'],
            [3, 'Troca', 'e'],
            [4, 'Consumo', 's'],
            [5, 'Troca', 's'],
            [6, 'Vencido', 's'],
        ];

        foreach ($movimentacoes as [$id, $nome, $tipo]) {
            TipoMovimentacao::updateOrCreate(
                ['id_tipo_movimentacao' => $id],
                ['nome' => $nome, 'tipo' => $tipo]
            );
        }
    }
}
