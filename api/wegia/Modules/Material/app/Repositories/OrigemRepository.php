<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\Models\Origem;

class OrigemRepository extends BaseRepository
{
    public function __construct(
        Origem $model
    )
    {
        parent::__construct($model);
    }

}
