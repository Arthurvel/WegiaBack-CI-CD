<?php

namespace Modules\Saude\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SaudeMedicosSeeder::class,
            SaudeExameTiposSeeder::class,
            SaudeTabelaCidSeeder::class,
        ]);
    }
}
