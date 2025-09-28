<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeIntercorrenciaCadastrarDTO extends BaseDTO
{
    public string $descricao;
    public int $id_funcionario;
    public int $id_fichamedica;
}
