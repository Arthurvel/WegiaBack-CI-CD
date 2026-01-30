<?php

namespace app\Models\Atendido\Aceitacao;

use App\Models\Atendido\Aceitacao\AtendidoAceitacaoPaStatus;
use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa\Pessoa;

class AtendidoAceitacaoProcessoDeAceitacao extends BaseModel
{
    protected $table = 'processo_de_aceitacao';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'data_inicio',
        'data_fim',
        'descricao',
        'id_status',
        'id_pessoa'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function status()
    {
        return $this->belongsTo(AtendidoAceitacaoPaStatus::class, 'id_status', 'id');
    }

    public function arquivos()
    {
        return $this->hasMany(AtendidoAceitacaoPaArquivo::class, 'id_processo', 'id');
    }

    public function etapas()
    {
        return $this->hasMany(AtendidoAceitacaoPaEtapa::class, 'id_processo', 'id');
    }
}

