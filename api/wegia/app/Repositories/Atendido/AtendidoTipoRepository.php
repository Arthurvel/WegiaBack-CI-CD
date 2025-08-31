<?php

namespace app\Repositories\Atendido;

use App\Models\Atendido\AtendidoTipo;
use App\Repositories\Base\BaseRepository;

class AtendidoTipoRepository extends BaseRepository
{

    public function __construct(
        AtendidoTipo $model
    )
    {
        parent::__construct($model);
    }

}
