<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class TransacaoProdutoAtualizarDTO extends BaseDTO
{

    public ?int $quantidade;
    public ?string $valor_unitario;

}
