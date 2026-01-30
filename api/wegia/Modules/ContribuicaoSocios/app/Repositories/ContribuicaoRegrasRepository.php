<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoRegras;

class ContribuicaoRegrasRepository extends BaseRepository
{

    public function __construct(
        ContribuicaoRegras $model
    )
    {
        parent::__construct($model);
    }

}
