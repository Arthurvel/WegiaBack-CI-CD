<?php

namespace app\Services\Configuracao;

use app\Repositories\Configuracao\CampoImagemRepository;
use App\Services\Base\BaseService;

class CampoImagemService extends BaseService
{

    public function __construct(
        CampoImagemRepository $repository
    )
    {
        parent::__construct($repository);
    }

}

