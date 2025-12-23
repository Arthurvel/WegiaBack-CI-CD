<?php

namespace Modules\ContribuicaoSocios\app\Repositories;
use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoRecorrencia;


class ContribuicaoRecorrenciaRepository extends BaseRepository
{

    public function __construct(
        ContribuicaoRecorrencia $model
    )
    {
        parent::__construct($model);
    }
}
