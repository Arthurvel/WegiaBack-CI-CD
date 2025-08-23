<?php

namespace Modules\Pet\app\Services;

use App\Services\Base\BaseService;
use Modules\Pet\app\Repositories\RacaRepository;

class RacaService extends BaseService
{

    public function __construct
    (
        RacaRepository $repository,
    )
    {
        parent::__construct($repository);
    }

}
