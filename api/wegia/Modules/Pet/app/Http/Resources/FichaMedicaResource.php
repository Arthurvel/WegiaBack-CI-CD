<?php

namespace Modules\Pet\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FichaMedicaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_ficha_medica'        => $this->id_ficha_medica,
            'id_pet'                 => $this->id_pet,
            'castrado'               => $this->castrado,
            'necessidades_especiais' => $this->necessidades_especiais,
            'atendimento'            => $this->relationLoaded('atendimento')
                ? AtendimentoResource::collection($this->atendimento) : null
        ];
    }

}
