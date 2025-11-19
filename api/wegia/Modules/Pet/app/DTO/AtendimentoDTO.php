<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class AtendimentoDTO extends BaseDTO
{
    public int $id_ficha_medica;
    public string $data_atendimento;
    public string $descricao;
}

