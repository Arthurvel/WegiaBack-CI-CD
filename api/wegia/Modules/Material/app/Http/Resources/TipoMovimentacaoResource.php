<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TipoMovimentacaoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_tipo_movimentacao' => $this->id_tipo_movimentacao,
            'nome'                 => $this->nome,
            'tipo'                 => $this->tipo,
        ];
    }
}
