<?php

namespace app\Repositories\Pessoa;

use app\Models\Pessoa\PessoaTipoArquivo;
use App\Repositories\Base\BaseRepository;

class PessoaTipoArquivoRepository extends BaseRepository
{

    public function __construct(
        PessoaTipoArquivo $model
    )
    {
        parent::__construct($model);
    }

}
