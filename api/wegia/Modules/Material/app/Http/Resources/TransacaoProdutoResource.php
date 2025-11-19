<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransacaoProdutoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_transacao_produto' => $this->id_transacao_produto,
            'id_transacao'         => $this->id_transacao,
            'id_produto'           => $this->id_produto,
            'quantidade'           => $this->quantidade,
            'valor_unitario'       => $this->valor_unitario,

            'produto' => $this->relationLoaded('produto')
                ? new ProdutoResource($this->produto)
                : null,

        ];
    }
}
