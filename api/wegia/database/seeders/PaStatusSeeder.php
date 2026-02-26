<?php

namespace Database\Seeders;

use App\Models\Atendido\Aceitacao\AtendidoAceitacaoPaStatus;
use Illuminate\Database\Seeder;

class PaStatusSeeder extends Seeder
{
    public function run(): void
    {
        $status = ['Em Andamento', 'Concluído', 'Cancelado', 'Aguardando Aprovação'];

        foreach ($status as $s) {
            AtendidoAceitacaoPaStatus::firstOrCreate(
                ['descricao' => $s]
            );
        }
    }
}
