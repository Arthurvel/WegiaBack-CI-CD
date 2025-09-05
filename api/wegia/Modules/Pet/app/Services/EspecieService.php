<?php

namespace Modules\Pet\app\Services;

use App\Services\Base\BaseService;
use Modules\Pet\app\Repositories\EspecieRepository;

class EspecieService extends BaseService
{

    public function __construct
    (
        EspecieRepository $repository,
    )
    {
        parent::__construct($repository);
    }

}
