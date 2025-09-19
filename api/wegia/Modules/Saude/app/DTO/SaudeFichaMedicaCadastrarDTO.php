<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeFichaMedicaCadastrarDTO extends BaseDTO
{

    public int $id_pessoa;
    public string $prontuario;

}
