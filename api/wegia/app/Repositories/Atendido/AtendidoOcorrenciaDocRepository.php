<?php

namespace app\Repositories\Atendido;

use App\Models\Atendido\OcorrenciaDoc;
use App\Repositories\Base\BaseRepository;

class AtendidoOcorrenciaDocRepository extends BaseRepository
{

    public function __construct(
        OcorrenciaDoc $model
    )
    {
        parent::__construct($model);
    }

}
