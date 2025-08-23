<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\Models\PetFoto;

class PetFotoRepository extends BaseRepository
{

    public function __construct(
        PetFoto $model
    )
    {
        parent::__construct($model);
    }

}
