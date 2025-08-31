<?php

namespace App\DTOs;

class PaginacaoDTO extends BaseDTO
{
    public array $items;
    public int $paginaAtual;
    public int $totalPaginas;
    public int $totalItens;
    public int $itensPorPagina;

}
