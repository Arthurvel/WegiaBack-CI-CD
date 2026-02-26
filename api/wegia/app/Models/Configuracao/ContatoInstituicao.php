<?php

namespace app\Models\Configuracao;

use App\Models\BaseModel\BaseModel;

class ContatoInstituicao extends BaseModel
{

    protected $table = 'contato_instituicao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'descricao',
        'contato'
    ];

}

