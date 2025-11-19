<?php

namespace app\Services\Atendido;

use app\Repositories\Atendido\AtendidoTipoRepository;
use App\Services\Base\BaseService;

class AtendidoTipoService extends BaseService
{

    public function __construct(
        AtendidoTipoRepository $repository
    )
    {
        parent::__construct($repository);
    }

}
