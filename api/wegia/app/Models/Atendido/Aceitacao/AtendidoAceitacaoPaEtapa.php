<?php

namespace app\Models\Atendido\Aceitacao;

use App\Models\Atendido\Aceitacao\AtendidoAceitacaoPaStatus;
use App\Models\BaseModel\BaseModel;

class AtendidoAceitacaoPaEtapa extends BaseModel
{
    protected $table = 'pa_etapa';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'data_inicio',
        'data_fim',
        'descricao',
        'id_status',
        'id_processo'
    ];

    public function status()
    {
        return $this->belongsTo(AtendidoAceitacaoPaStatus::class, 'id_status', 'id');
    }

    public function arquivos()
    {
        return $this->hasMany(AtendidoAceitacaoEtapaArquivo::class, 'etapa_id', 'id');
    }
}
