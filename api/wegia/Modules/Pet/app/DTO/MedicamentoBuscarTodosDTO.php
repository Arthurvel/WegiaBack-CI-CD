<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class MedicamentoBuscarTodosDTO extends BaseDTO
{
    public ?string $buscar = null;
    public ?string $ordenacao = null;
    public ?string $tipoOrdenacao = null;
    public int $pagina = 1;
    public int $itensPorPagina = 10;
}
