<?php

namespace app\Services\Atendido;

use app\Repositories\Atendido\AtendidoStatusRepository;
use App\Services\Base\BaseService;

class AtendidoStatusService extends BaseService
{

    public function __construct(
        AtendidoStatusRepository $repository
    )
    {
        parent::__construct($repository);
    }


}
