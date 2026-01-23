<?php

namespace app\Repositories\Atendido\Aceitacao;

use app\Models\Atendido\Aceitacao\AtendidoAceitacaoPaArquivo;
use App\Repositories\Base\BaseRepository;

class AtendidoAceitacaoPaArquivoRepository extends BaseRepository
{

    public function __construct(
        AtendidoAceitacaoPaArquivo $model
    )
    {
        parent::__construct($model);
    }

}

