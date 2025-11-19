<?php

namespace Modules\Pet\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendimentoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pet_atendimento' => $this->id_pet_atendimento,
            'id_ficha_medica'    => $this->id_ficha_medica,
            'data_atendimento'   => $this->data_atendimento ? Carbon::parse($this->data_atendimento)->format('d/m/Y') : null,
            'descricao'          => $this->descricao,
            'medicacao'          => $this->relationLoaded('medicacao')
                ? MedicacaoResource::collection($this->medicacao) : null
        ];
    }

}
