<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class TransacaoProdutoCadastrarDTO extends BaseDTO
{
    public int $id_transacao;
    public int $id_produto;
    public int $quantidade;
    public string $valor_unitario;
}
