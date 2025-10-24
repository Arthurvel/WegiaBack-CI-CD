<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class TransacaoAtualizarDTO extends BaseDTO
{
    public ?int $id_produto;
    public ?int $id_tipo_movimentacao;
    public ?int $id_almoxarifado;
    public ?int $id_parceiro;
    public ?float $valor_unitario;
    public ?int $quantidade;
}
