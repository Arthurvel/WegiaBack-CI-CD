<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class MedicamentoAtualizarDTO extends BaseDTO
{

    public ?string $nome_medicamento;
    public ?string $descricao_medicamento;
    public ?string $aplicacao;

}
