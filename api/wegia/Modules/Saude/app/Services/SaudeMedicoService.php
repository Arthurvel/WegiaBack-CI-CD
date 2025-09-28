<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\Repositories\SaudeMedicoRepository;

class SaudeMedicoService extends BaseService
{

    public function __construct
    (
        SaudeMedicoRepository $repository
    )
    {
        parent::__construct($repository);
    }


}
