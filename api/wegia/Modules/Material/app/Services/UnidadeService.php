<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\Repositories\UnidadeRepository;

class UnidadeService extends BaseService
{

    public function __construct
    (
        UnidadeRepository $repository,
    )
    {
        parent::__construct($repository);
    }
}
