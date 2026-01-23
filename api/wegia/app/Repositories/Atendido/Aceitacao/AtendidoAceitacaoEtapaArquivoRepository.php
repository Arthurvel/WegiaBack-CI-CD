<?php

namespace app\Repositories\Atendido\Aceitacao;

use app\Models\Atendido\Aceitacao\AtendidoAceitacaoEtapaArquivo;
use App\Repositories\Base\BaseRepository;

class AtendidoAceitacaoEtapaArquivoRepository extends BaseRepository
{

    public function __construct(
        AtendidoAceitacaoEtapaArquivo $model
    )
    {
        parent::__construct($model);
    }

}
