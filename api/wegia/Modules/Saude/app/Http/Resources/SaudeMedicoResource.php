<?php

namespace Modules\Saude\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaudeMedicoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_medico' => $this->id_medico,
            'crm'       => $this->crm,
            'nome'      => $this->nome
        ];
    }

}
