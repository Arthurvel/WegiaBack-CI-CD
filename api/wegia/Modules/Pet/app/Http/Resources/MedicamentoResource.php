<?php

namespace Modules\Pet\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicamentoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_medicamento'        => $this->id_medicamento,
            'nome_medicamento'      => $this->nome_medicamento,
            'descricao_medicamento' => $this->descricao_medicamento,
            'aplicacao'             => $this->aplicacao,
        ];
    }

}
