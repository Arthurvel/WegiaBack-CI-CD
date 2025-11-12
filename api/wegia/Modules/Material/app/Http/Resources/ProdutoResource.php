<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_produto'   => $this->id_produto,
            'id_categoria'   => $this->id_categoria,
            'id_unidade'   => $this->id_unidade,
            'descricao'        => $this->descricao,
            'codigo'        => $this->codigo,
            'oculto'        => $this->oculto,
            'categoria'       => $this->relationLoaded('categoria') ?
                new CategoriaResource($this->categoria) : null,
            'unidade'           => $this->relationLoaded('unidade') ?
                new UnidadeResource($this->unidade) : null,
        ];
    }

}
