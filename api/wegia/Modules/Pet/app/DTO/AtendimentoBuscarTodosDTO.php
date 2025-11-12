<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class AtendimentoBuscarTodosDTO extends BaseDTO
{
    public int $id_ficha_medica;
    public ?string $ordenacao = null;
    public ?string $tipoOrdenacao = null;
    public int $pagina = 1;
    public int $itensPorPagina = 10;
}
