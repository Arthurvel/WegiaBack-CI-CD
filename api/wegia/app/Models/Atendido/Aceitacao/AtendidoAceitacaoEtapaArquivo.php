<?php

namespace app\Models\Atendido\Aceitacao;
use App\Models\BaseModel\BaseModel;


class AtendidoAceitacaoEtapaArquivo extends BaseModel
{
    protected $table = 'etapa_arquivo';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'etapa_id',
        'arquivo_nome',
        'arquivo_extensao',
        'arquivo'
    ];
}
