<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\Models\SocioStatus;

class SocioStatusRepository extends BaseRepository
{

    public function __construct(
        SocioStatus $model
    )
    {
        parent::__construct($model);
    }
}
