<?php

namespace Database\Seeders;

use App\Models\Atendido\AtendidoStatus;
use Illuminate\Database\Seeder;

class AtendidoStatusSeeder extends Seeder
{
    public function run(): void
    {
        $status = [
            ['idatendido_status' => 1, 'status' => 'Ativo'],
            ['idatendido_status' => 2, 'status' => 'Inativo'],
        ];

        foreach ($status as $s) {
            AtendidoStatus::firstOrCreate(
                ['idatendido_status' => $s['idatendido_status']],
                ['status' => $s['status']]
            );
        }
    }
}
