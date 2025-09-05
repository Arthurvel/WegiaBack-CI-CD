<?php

namespace app\Services\Pessoa;

use app\Repositories\Pessoa\PessoaTipoArquivoRepository;
use App\Services\Base\BaseService;

class PessoaTipoArquivoService extends BaseService
{

    public function __construct(
        PessoaTipoArquivoRepository $repository
    )
    {
        parent::__construct($repository);
    }

}
