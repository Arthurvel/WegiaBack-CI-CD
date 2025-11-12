<?php

namespace Modules\Material\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatorioResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_transacao'         => $this->id_transacao,
            'id_tipo_movimentacao' => $this->id_tipo_movimentacao,
            'id_responsavel'       => $this->id_responsavel,
            'id_parceiro'          => $this->id_parceiro,
            'id_almoxarifado'      => $this->id_almoxarifado,
            'id_produto'           => $this->id_produto,
            'tipo_movimentacao'    => $this->tipo_movimentacao,
            'tipo'                 => $this->tipo,
            'almoxarifado'         => $this->almoxarifado,
            'produto'              => $this->produto,
            'unidade'              => $this->unidade,
            'quantidade_total'     => (int) $this->quantidade_total,
            'valor_total'          => (float) $this->valor_total,
            'valor_unitario'          => (float) $this->valor_unitario,
            'parceiro'             => $this->parceiro,
            'responsavel'          => $this->responsavel,
            'data'                => Carbon::parse($this->data)->format('d/m/Y')
        ];
    }
}
