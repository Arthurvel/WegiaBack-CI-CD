<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoRegrasRepository;

class ContribuicaoRegrasService extends BaseService
{

    public function __construct
    (
        ContribuicaoRegrasRepository $repository,
    )
    {
        parent::__construct($repository);
    }

}
