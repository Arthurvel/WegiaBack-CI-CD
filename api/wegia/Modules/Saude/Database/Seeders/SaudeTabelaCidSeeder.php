<?php

namespace Modules\Saude\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Saude\app\Models\SaudeCID;

class SaudeTabelaCidSeeder extends Seeder
{
    public function run(): void
    {
        $cids = [
            ['B34.2', 'Infecção por coronavírus de localização não especificada'],
        ];

        foreach ($cids as [$CID, $descricao]) {
            SaudeCID::updateOrCreate(
                ['CID' => $CID],
                ['descricao' => $descricao]
            );
        }
    }
}
