<?php

namespace app\Models\Configuracao;

use App\Models\BaseModel\BaseModel;

class EnderecoInstituicao extends BaseModel
{

    protected $table = 'endereco_instituicao';

    protected $primaryKey = 'id_inst';

    protected $fillable = [
        'nome',
        'numero_endereco',
        'logradouro',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'complemento',
        'ibge'
    ];

}
