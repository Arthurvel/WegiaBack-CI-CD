<?php

namespace App\DTOs;

class PaginacaoFiltrosDTO extends BaseDTO
{

    public ?string $buscar;
    public ?string $ordenacao;
    public ?string $tipoOrdenacao;
    public ?string $pagina;
    public ?string $itensPorPagina;

}
