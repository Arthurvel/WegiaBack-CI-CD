<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\Repositories\OrigemRepository;

class OrigemService extends BaseService
{

    public function __construct
    (
        OrigemRepository $repository,
    )
    {
        parent::__construct($repository);
    }

}
