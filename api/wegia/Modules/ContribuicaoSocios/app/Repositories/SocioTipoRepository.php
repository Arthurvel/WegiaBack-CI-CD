<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\Models\SocioTipo;

class SocioTipoRepository extends BaseRepository
{

    public function __construct(
        SocioTipo $model
    )
    {
        parent::__construct($model);
    }

}
