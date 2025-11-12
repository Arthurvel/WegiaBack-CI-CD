<?php

namespace Modules\Saude\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeEnfermidadeResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id_enfermidade'   => $this->id_enfermidade,
            'id_fichamedica'   => $this->id_fichamedica,
            'id_CID'           => $this->id_CID,
            'data_diagnostico' => $this->data_diagnostico
                ? Carbon::parse($this->data_diagnostico)->format('d/m/Y')
                : null,
            'status'           => $this->status,
            'cid'              => $this->relationLoaded('cid') ? new SaudeCIDResource($this->cid) : null
        ];
    }

}
