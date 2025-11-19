<?php

namespace app\Http\Resources\Atendido;

use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoOcorrenciaTipoResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'idatendido_ocorrencia_tipos' => $this->idatendido_ocorrencia_tipos,
            'descricao'                   => $this->descricao
        ];
    }

}
