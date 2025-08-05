<?php

namespace Modules\Memorando\app\DTO;

use App\DTOs\BaseDTO;

class DespachoBuscarTodosDTO extends BaseDTO
{
    public ?string $buscar = null;
    public ?string $ordenacao = null;
    public ?string $tipoOrdenacao = null;
    public ?string $status = null;
    public int $pagina = 1;
    public int $itensPorPagina = 10;
}
