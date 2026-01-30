<?php

namespace Modules\Material\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Material\app\Models\Categoria;

class MaterialCategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [1, 'Alimento'],
            [2, 'Higiene'],
            [3, 'Limpeza'],
            [4, 'Medicamento'],
            [5, 'Papelaria'],
        ];

        foreach ($categorias as [$id, $descricao]) {
            Categoria::updateOrCreate(
                ['id_categoria' => $id],
                ['descricao' => $descricao]
            );
        }
    }
}
