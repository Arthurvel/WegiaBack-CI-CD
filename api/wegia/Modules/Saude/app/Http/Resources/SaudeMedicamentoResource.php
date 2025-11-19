<?php

namespace Modules\Saude\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaudeMedicamentoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_medicacao'   => $this->id_medicacao,
            'id_atendimento' => $this->id_atendimento,
            'medicamento'    => $this->medicamento,
            'dosagem'        => $this->dosagem,
            'horario'        => $this->horario,
            'duracao'        => $this->duracao,
            'status'         => $this->status,
            'administracao'  => $this->relationLoaded('administracao')
                ? SaudeMedicamentoAdministracaoResource::collection($this->administracao) : null,

        ];
    }

}
