<?php

namespace app\Services\Configuracao;

use app\Repositories\Configuracao\ContatoInstituicaoRepository;
use App\Services\Base\BaseService;

class ContatoInstituicaoService extends BaseService
{

    public function __construct(
        ContatoInstituicaoRepository $repository
    )
    {
        parent::__construct($repository);
    }

}
