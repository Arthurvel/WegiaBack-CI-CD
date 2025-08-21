<?php

namespace Modules\Pet\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pet'                     => $this->id_pet,
            'nome'                       => $this->nome,
            'data_nascimento'            => $this->data_nascimento ? Carbon::parse($this->data_nascimento)->format('d/m/Y') : null,
            'data_acolhimento'           => $this->data_acolhimento ? Carbon::parse($this->data_acolhimento)->format('d/m/Y') : null,
            'sexo'                       => $this->sexo,
            'caracteristicas_especificas'=> $this->caracteristicas_especificas,
            'id_pet_foto'                => $this->id_pet_foto,
            'id_pet_especie'             => $this->id_pet_especie,
            'id_pet_raca'                => $this->id_pet_raca,
            'cor'                        => $this->cor,
            'especie'                    => $this->relationLoaded('especie') ? new EspecieResource($this->especie) : null,
            'raca'                       => $this->relationLoaded('raca') ? new RacaResource($this->raca) : null,
            'foto'                       => $this->relationLoaded('foto') ? new FotoResource($this->foto) : null,
        ];
    }

}
