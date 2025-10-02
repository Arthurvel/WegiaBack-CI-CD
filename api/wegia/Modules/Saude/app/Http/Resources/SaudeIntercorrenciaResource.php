<?php

namespace Modules\Saude\app\Http\Resources;

use App\Http\Resources\Funcionario\FuncionarioResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeIntercorrenciaResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_intercorrencia' => $this->id_intercorrencia,
            'id_funcionario'    => $this->id_funcionario,
            'id_fichamedica'    => $this->id_fichamedica,
            'data'              => $this->data
                ?  Carbon::parse($this->data)->format('d/m/Y H:i:s') : null,
            'descricao'         => $this->descricao,
            'funcionario'       => $this->relationLoaded('funcionario')
                ? new FuncionarioResource($this->funcionario) : null

        ];
    }

}
