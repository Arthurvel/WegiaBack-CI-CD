<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\Models\SaudeExameTipos;

class SaudeExameTiposRepository extends BaseRepository
{

    public function __construct(
        SaudeExameTipos $model
    )
    {
        parent::__construct($model);
    }

}
