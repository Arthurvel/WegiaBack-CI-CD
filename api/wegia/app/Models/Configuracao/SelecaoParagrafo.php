<?php

namespace app\Models\Configuracao;

use App\Models\BaseModel\BaseModel;

class SelecaoParagrafo extends BaseModel
{

    protected $table = 'selecao_paragrafo';

    protected $primaryKey = 'id_selecao';

    protected $fillable = [
        'nome_campo',
        'paragrafo',
        'original'
    ];

}
