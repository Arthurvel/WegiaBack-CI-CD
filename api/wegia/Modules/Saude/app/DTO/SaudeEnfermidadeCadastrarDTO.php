<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeEnfermidadeCadastrarDTO extends BaseDTO
{

    public int $id_CID;
    public int $id_fichamedica;
    public string $data_diagnostico;
    public int $status;

}
