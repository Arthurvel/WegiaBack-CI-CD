<?php

namespace Modules\ContribuicaoSocios\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContribuicaoSocios\app\Models\SocioTipo;

class SocioTipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            [0, 'Física - Casual - Boleto'],
            [1, 'Jurídica - Casual - Boleto'],
            [2, 'Física - Mensal - Boleto'],
            [3, 'Jurídica - Mensal - Boleto'],
            [4, 'Física - Sem informação'],
            [5, 'Jurídica - Sem informação'],
            [6, 'Física - Bimestral - Boleto'],
            [7, 'Jurídica - Bimestral - Boleto'],
            [8, 'Física - Trimestral - Boleto'],
            [9, 'Jurídica - Trimestral - Boleto'],
            [10, 'Física - Semestral - Boleto'],
            [11, 'Jurídica - Semestral - Boleto'],
            [12, 'Física - Anual - Boleto'],
            [13, 'Jurídica - Anual - Boleto'],

            [20, 'Física - Casual - Cartão'],
            [21, 'Jurídica - Casual - Cartão'],
            [22, 'Física - Mensal - Cartão'],
            [23, 'Jurídica - Mensal - Cartão'],
            [24, 'Física - Bimestral - Cartão'],
            [25, 'Jurídica - Bimestral - Cartão'],
            [26, 'Física - Trimestral - Cartão'],
            [27, 'Jurídica - Trimestral - Cartão'],
            [28, 'Física - Semestral - Cartão'],
            [29, 'Jurídica - Semestral - Cartão'],
            [30, 'Física - Anual - Cartão'],
            [31, 'Jurídica - Anual - Cartão'],

            [40, 'Física - Casual - Outros'],
            [41, 'Jurídica - Casual - Outros'],
            [42, 'Física - Mensal - Outros'],
            [43, 'Jurídica - Mensal - Outros'],
            [44, 'Física - Bimestral - Outros'],
            [45, 'Jurídica - Bimestral - Outros'],
            [46, 'Física - Trimestral - Outros'],
            [47, 'Jurídica - Trimestral - Outros'],
            [48, 'Física - Semestral - Outros'],
            [49, 'Jurídica - Semestral - Outros'],
            [50, 'Física - Anual - Outros'],
            [51, 'Jurídica - Anual - Outros'],
        ];

        foreach ($tipos as [$id, $descricao]) {
            SocioTipo::firstOrCreate(
                ['id_sociotipo' => $id],
                ['tipo' => $descricao]
            );
        }
    }
}
