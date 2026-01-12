<?php

namespace app\Models\Configuracao;

use App\Models\BaseModel\BaseModel;

class TabelaImagemCampo extends BaseModel
{

    protected $table = 'tabela_imagem_campo';

    protected $primaryKey = 'id_relacao';

    protected $fillable = [
        'id_campo',
        'id_imagem'
    ];

}
