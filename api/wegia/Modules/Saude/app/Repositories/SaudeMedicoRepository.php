<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\Models\SaudeMedico;

class SaudeMedicoRepository extends BaseRepository
{

    public function __construct(
        SaudeMedico $model
    )
    {
        parent::__construct($model);
    }


}
