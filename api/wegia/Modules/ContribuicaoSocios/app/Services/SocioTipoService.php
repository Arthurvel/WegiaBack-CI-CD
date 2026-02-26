<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\Repositories\SocioTipoRepository;

class SocioTipoService extends BaseService
{

    public function __construct
    (
        SocioTipoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

}
