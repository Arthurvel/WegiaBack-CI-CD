<?php

namespace Modules\Saude\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaudeFichaMedicaAlergiaResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id_fichamedica_alergia" => $this->id_fichamedica_alergia,
            "id_fichamedica"         => $this->id_fichamedica,
            "id_alergia"             => $this->id_alergia,
            "alergias"               => $this->relationLoaded('alergias')
                ? new SaudeAlergiaResource($this->alergias) : null
        ];
    }

}
