<?php

namespace App\DTOs\Atendido;

use App\DTOs\BaseDTO;

class AtendidoOcorrenciaCadastrarDTO extends BaseDTO
{
    public int $atendido_idatendido;
    public int $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos;
    public int $funcionario_id_funcionario;
    public string $data;
    public string $descricao;

}
