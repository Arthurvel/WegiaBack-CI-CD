<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoMeioPagamentoCadastrarDTO extends BaseDTO
{

    public string $meio;
    public string $id_plataforma;
    public string $status;

}
