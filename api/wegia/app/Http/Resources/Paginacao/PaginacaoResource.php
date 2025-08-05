<?php

namespace App\Http\Resources\Paginacao;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginacaoResource extends ResourceCollection
{
    protected $itemResource = null;

    public function __construct($resource, $itemResource = null)
    {
        parent::__construct($resource);
        $this->itemResource = $itemResource;
    }

    public function toArray($request) : array
    {
        $items = null;
        if($this->itemResource) {
            $items = call_user_func($this->itemResource . '::collection', $this->collection);
        } else {
            $items = $this->collection;
        }

        return [
            'items'          => $items,
            'paginaAtual'    => $this->currentPage(),
            'totalPaginas'   => $this->lastPage(),
            'totalItens'     => $this->total(),
            'itensPorPagina' => $this->perPage()
        ];
    }
}
