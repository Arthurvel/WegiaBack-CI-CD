<?php

namespace app\Repositories\Configuracao;

use app\Models\Configuracao\ContatoInstituicao;
use App\Repositories\Base\BaseRepository;

class ContatoInstituicaoRepository extends BaseRepository
{

    public function __construct(
        ContatoInstituicao $model
    )
    {
        parent::__construct($model);
    }

}
