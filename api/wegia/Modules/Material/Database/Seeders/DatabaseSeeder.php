<?php

namespace Modules\Material\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MaterialCategoriaSeeder::class,
            MaterialParceiroSeeder::class,
            MaterialTipoMovimentacaoSeeder::class
        ]);
    }
}
