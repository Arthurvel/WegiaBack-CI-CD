<?php

namespace Modules\Saude\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeFichaMedicaProntuarioHistoricoResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id_prontuario_historico' => $this->id_prontuario_historico,
            'id_fichamedica'          => $this->id_fichamedica,
            'prontuario'              => $this->prontuario,
            'data'                    => $this->data
                ? Carbon::parse($this->data)->format('d/m/Y H:i:s')
                : null
        ];
    }

}
