<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\Models\SaudeCID;

class SaudeCIDRepository extends BaseRepository
{

    public function __construct(
        SaudeCID $model
    )
    {
        parent::__construct($model);
    }

}
