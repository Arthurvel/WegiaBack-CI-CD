<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\Models\Unidade;

class UnidadeRepository extends BaseRepository
{

    public function __construct(
        Unidade $model
    )
    {
        parent::__construct($model);
    }
}
