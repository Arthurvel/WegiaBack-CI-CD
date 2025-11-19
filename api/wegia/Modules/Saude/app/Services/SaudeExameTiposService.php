<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\Repositories\SaudeExameTiposRepository;

class SaudeExameTiposService extends BaseService
{

    public function __construct
    (
        SaudeExameTiposRepository $repository,
    )
    {
        parent::__construct($repository);
    }


}
