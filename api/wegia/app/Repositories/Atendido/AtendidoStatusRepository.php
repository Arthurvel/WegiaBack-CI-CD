<?php

namespace app\Repositories\Atendido;

use App\Models\Atendido\AtendidoStatus;
use App\Repositories\Base\BaseRepository;

class AtendidoStatusRepository extends BaseRepository
{

    public function __construct(
        AtendidoStatus $model
    )
    {
        parent::__construct($model);
    }


}
