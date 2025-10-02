<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\Models\SaudeFichaMedicaProntuarioHistorico;

class SaudeFichaMedicaProntuarioHistoricoRepository extends BaseRepository
{

    public function __construct(
        SaudeFichaMedicaProntuarioHistorico $model
    )
    {
        parent::__construct($model);
    }

}
