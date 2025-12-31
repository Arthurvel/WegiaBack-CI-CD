<?php

namespace app\Services\Configuracao;

use app\Repositories\Configuracao\SelecaoParagrafoRepository;
use App\Services\Base\BaseService;

class SelecaoParagrafoService extends BaseService
{

    public function __construct(
        SelecaoParagrafoRepository $repository
    )
    {
        parent::__construct($repository);
    }

}
