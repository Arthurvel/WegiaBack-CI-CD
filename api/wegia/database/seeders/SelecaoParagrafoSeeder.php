<?php

namespace Database\Seeders;

use app\Models\Configuracao\SelecaoParagrafo;
use Illuminate\Database\Seeder;

class SelecaoParagrafoSeeder extends Seeder
{
    public function run(): void{

        $paragrafos = [
            ['id_selecao'=>1,'nome_campo'=>'Titulo','paragrafo'=>'WeGIA','original'=>1],
            ['id_selecao'=>2,'nome_campo'=>'Subtitulo','paragrafo'=>'Web Gerenciador Institucional','original'=>1],
            ['id_selecao'=>3,'nome_campo'=>'Conheça','paragrafo'=>'O WEGIA é um software livre licenciado pela GNU/GPL v3.','original'=>1],
            ['id_selecao'=>4,'nome_campo'=>'Objetivo','paragrafo'=>'Promover uma boa administração...','original'=>1],
        ];

        foreach ($paragrafos as $p) {
            SelecaoParagrafo::firstOrCreate(
                ['id_selecao' => $p['id_selecao']],
                $p
            );
        }

    }
}
