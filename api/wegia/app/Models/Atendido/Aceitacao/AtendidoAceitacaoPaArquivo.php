<?php

namespace app\Models\Atendido\Aceitacao;

use App\Models\BaseModel\BaseModel;

class AtendidoAceitacaoPaArquivo extends BaseModel
{
    protected $table = 'pa_arquivo';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'id_processo',
        'id_etapa',
        'arquivo_nome',
        'arquivo_extensao',
        'arquivo'
    ];
}

