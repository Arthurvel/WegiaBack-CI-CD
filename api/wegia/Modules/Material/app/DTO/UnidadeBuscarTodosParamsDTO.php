<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class UnidadeBuscarTodosParamsDTO extends BaseDTO
{
    public ?string $buscar;
    public ?string $ordenacao;
    public ?string $tipoOrdenacao;
    public ?string $pagina;
    public ?string $itensPorPagina;
}
