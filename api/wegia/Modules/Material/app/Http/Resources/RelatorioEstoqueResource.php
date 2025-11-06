<?php

namespace Modules\Material\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatorioEstoqueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_transacao'        => $this->id_transacao,
            'id_almoxarifado'     => $this->id_almoxarifado,
            'id_produto'          => $this->id_produto,
            'produto'             => $this->produto,
            'unidade'             => $this->unidade,
            'quantidade_entradas' => (int) $this->quantidade_entradas,
            'quantidade_saidas'   => (int) $this->quantidade_saidas,
            'quantidade_estoque'  => (int) $this->quantidade_estoque,
            'total'               => (float) $this->total,
            'preco_medio'         => (float) $this->preco_medio
        ];
    }
}
