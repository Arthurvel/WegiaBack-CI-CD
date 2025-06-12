<?php

namespace App\DTOs;

class PaginacaoDTO
{
    public array $items;
    public int $paginaAtual;
    public int $totalPaginas;
    public int $totalItens;
    public int $itensPorPagina;

    public function __construct(
        array $items, 
        int $paginaAtual, 
        int $totalPaginas, 
        int $totalItens, 
        int $itensPorPagina
    )
    {
        $this->items = $items;
        $this->paginaAtual = $paginaAtual;
        $this->totalPaginas = $totalPaginas;
        $this->totalItens = $totalItens;
        $this->itensPorPagina = $itensPorPagina;
    }

    public static function fromArray($paginator): self
    {
        return new self(
            $paginator->items(),
            $paginator->currentPage(),
            $paginator->lastPage(),
            $paginator->total(),
            $paginator->perPage()
        );
    }
}
