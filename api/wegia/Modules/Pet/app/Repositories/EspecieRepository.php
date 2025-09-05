<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\Models\Especie;

class EspecieRepository extends BaseRepository
{

    public function __construct(
        Especie $model
    )
    {
        parent::__construct($model);
    }

}

