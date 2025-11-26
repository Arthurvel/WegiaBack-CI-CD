<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\Repositories\SocioStatusRepository;

class SocioStatusService extends BaseService
{

    public function __construct
    (
        SocioStatusRepository $repository,
    )
    {
        parent::__construct($repository);
    }

}
