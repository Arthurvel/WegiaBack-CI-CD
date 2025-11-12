<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeAtendimentoCadastrarDTO extends BaseDTO
{

    public int $id_fichamedica;
    public int $id_funcionario;
    public int $id_medico;
    public ?string $data_atendimento = null;
    public ?string $descricao = null;

}
