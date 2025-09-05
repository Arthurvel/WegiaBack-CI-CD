<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\Models\Raca;

class RacaRepository extends BaseRepository
{

    public function __construct(
        Raca $model
    )
    {
        parent::__construct($model);
    }

}
