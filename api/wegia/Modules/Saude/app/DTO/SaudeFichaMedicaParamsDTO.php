<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeFichaMedicaParamsDTO extends BaseDTO
{
    public ?string $buscar = null;
    public ?string $ordenacao = null;
    public ?string $tipoOrdenacao = null;
    public ?int $pagina = 1;
    public ?int $itensPorPagina = 10;
}
