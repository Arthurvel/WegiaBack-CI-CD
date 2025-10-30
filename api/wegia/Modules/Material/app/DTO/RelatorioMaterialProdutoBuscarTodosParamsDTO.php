<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class RelatorioMaterialProdutoBuscarTodosParamsDTO extends BaseDTO
{

    public ?string $periodo_inicial = null;
    public ?string $periodo_final = null;
    public ?int $id_produto = null;
    public ?int $id_almoxarifado = null;

}

