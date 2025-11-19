<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class TransacaoCadastrarDTO extends BaseDTO
{
    public int $id_tipo_movimentacao;
    public int $id_almoxarifado;
    public int $id_responsavel;
    public int $id_parceiro;
}
