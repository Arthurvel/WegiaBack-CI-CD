<?php

namespace app\Services\Atendido\Aceitacao;

use app\Repositories\Atendido\Aceitacao\AtendidoAceitacaoPaStatusRepository;
use App\Services\Base\BaseService;

class AtendidoAceitacaoPaStatusService extends BaseService
{

    public function __construct(
        AtendidoAceitacaoPaStatusRepository $repository,
    )
    {
        parent::__construct($repository);
    }

}
