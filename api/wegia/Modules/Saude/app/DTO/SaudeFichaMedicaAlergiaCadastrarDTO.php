<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeFichaMedicaAlergiaCadastrarDTO extends BaseDTO
{

    public int $id_fichamedica;
    public int $id_alergia;

}
