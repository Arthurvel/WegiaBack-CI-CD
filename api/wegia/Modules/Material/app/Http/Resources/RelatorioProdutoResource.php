<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class RelatorioProdutoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_transacao'        => $this->id_transacao,
            'id_tipo_movimentacao'=> $this->id_tipo_movimentacao,
            'id_responsavel'      => $this->id_responsavel,
            'id_almoxarifado'     => $this->id_almoxarifado,
            'id_produto'          => $this->id_produto,
            'id_parceiro'         => $this->id_parceiro,
            'data'                => $this->data
                ? Carbon::parse($this->data)->format('d/m/Y')
                : null,
            'tipo_movimentacao'   => $this->tipo_movimentacao,
            'tipo'                => $this->tipo,
            'almoxarifado'        => $this->almoxarifado,
            'parceiro'            => $this->parceiro,
            'responsavel'         => $this->responsavel,
            'produto'             => $this->produto,
            'unidade'             => $this->unidade,
            'quantidade'          => (float) $this->quantidade,
            'valor_unitario'      => (float) $this->valor_unitario,
            'total'               => (float) $this->total,
        ];
    }
}
