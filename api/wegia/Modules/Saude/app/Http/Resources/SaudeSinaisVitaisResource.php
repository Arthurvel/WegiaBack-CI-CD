<?php

namespace Modules\Saude\app\Http\Resources;

use App\Http\Resources\Funcionario\FuncionarioResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeSinaisVitaisResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_sinais_vitais'        => $this->id_sinais_vitais,
            'id_fichamedica'          => $this->id_fichamedica,
            'id_funcionario'          => $this->id_funcionario,
            'data'                    => $this->data ? Carbon::parse($this->data)->format('d/m/Y H:i:s') : null,
            'saturacao'               => $this->saturacao,
            'pressao_arterial'        => $this->pressao_arterial,
            'frequencia_cardiaca'     => $this->frequencia_cardiaca,
            'frequencia_respiratoria' => $this->frequencia_respiratoria,
            'temperatura'             => $this->temperatura,
            'hgt'                     => $this->hgt,
            'funcionario'             => $this->relationLoaded('funcionario') ?
                new FuncionarioResource($this->funcionario) : null,
        ];
    }

}
