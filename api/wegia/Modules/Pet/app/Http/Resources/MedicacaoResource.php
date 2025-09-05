<?php

namespace Modules\Pet\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicacaoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_medicacao'       => $this->id_medicacao,
            'id_medicamento'     => $this->id_medicamento,
            'id_pet_atendimento' => $this->id_pet_atendimento,
            'data_medicacao'     => $this->data_medicacao ? Carbon::parse($this->data_medicacao)->format('d/m/Y') : null,
            'medicamento'        => $this->relationLoaded('medicamento')
                ? new MedicamentoResource($this->medicamento) : null
        ];
    }

}
