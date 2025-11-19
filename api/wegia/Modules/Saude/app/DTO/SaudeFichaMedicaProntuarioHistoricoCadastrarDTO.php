<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeFichaMedicaProntuarioHistoricoCadastrarDTO extends BaseDTO
{

    public int $id_fichamedica;
    public string $prontuario;

}
