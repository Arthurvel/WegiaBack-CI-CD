<?php

namespace app\Repositories\Atendido\Aceitacao;

use App\Models\Atendido\Aceitacao\AtendidoAceitacaoPaStatus;
use App\Repositories\Base\BaseRepository;

class AtendidoAceitacaoPaStatusRepository extends BaseRepository
{

    public function __construct(
        AtendidoAceitacaoPaStatus $model
    )
    {
        parent::__construct($model);
    }

}
