<?php

namespace Modules\Saude\app\Http\Resources;

use App\Http\Resources\Pessoa\PessoaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeFichaMedicaResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id_fichamedica' => $this->id_fichamedica,
            'id_pessoa'      => $this->id_pessoa,
            'prontuario'     => $this->prontuario,
            'pessoa'         => $this->relationLoaded('pessoa') ? new PessoaResource($this->pessoa) : null,
            'historico'      => $this->relationLoaded('historico') ? SaudeFichaMedicaProntuarioHistoricoResource::collection($this->historico) : null,
        ];
    }

}
