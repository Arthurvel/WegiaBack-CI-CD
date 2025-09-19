<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\Repositories\SaudeCIDRepository;

class SaudeCIDService extends BaseService
{

    public function __construct
    (
        SaudeCIDRepository $repository,
    )
    {
        parent::__construct($repository);
    }


}
