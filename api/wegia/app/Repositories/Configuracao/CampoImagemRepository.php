<?php

namespace app\Repositories\Configuracao;

use app\Models\Configuracao\CampoImagem;
use App\Repositories\Base\BaseRepository;

class CampoImagemRepository extends BaseRepository
{

    public function __construct(
        CampoImagem $model
    )
    {
        parent::__construct($model);
    }

}
