<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\Models\Parceiro;

class ParceiroRepository extends BaseRepository
{

    public function __construct(
        Parceiro $model
    )
    {
        parent::__construct($model);
    }
}
