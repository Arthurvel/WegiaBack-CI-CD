<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class ProdutoCadastrarDTO extends BaseDTO
{
    public int $id_categoria;
    public int $id_unidade;
    public string $descricao;
    public ?string $codigo;
    public bool $oculto;
}
