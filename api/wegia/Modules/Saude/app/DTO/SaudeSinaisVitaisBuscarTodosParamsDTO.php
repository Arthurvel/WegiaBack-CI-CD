<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeSinaisVitaisBuscarTodosParamsDTO extends BaseDTO
{

    public int $id_fichamedica;
    public ?string $buscar = null;
    public ?string $ordenacao = null;
    public ?string $tipoOrdenacao = null;
    public ?int $pagina = null;
    public ?int $itensPorPagina = null;

}
