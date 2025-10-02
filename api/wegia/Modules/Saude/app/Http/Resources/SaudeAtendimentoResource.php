<?php

namespace Modules\Saude\app\Http\Resources;

use App\Http\Resources\Funcionario\FuncionarioResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeAtendimentoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_atendimento'   => $this->id_atendimento,
            'id_fichamedica'   => $this->id_fichamedica,
            'id_funcionario'   => $this->id_funcionario,
            'id_medico'        => $this->id_medico,
            'data_registro'    => Carbon::parse($this->data_registro)->format('d/m/Y'),
            'data_atendimento' => Carbon::parse($this->data_atendimento)->format('d/m/Y'),
            'descricao'        => $this->descricao,
            'medicacoes'       => $this->relationLoaded('medicacoes') ?
                SaudeMedicamentoResource::collection($this->medicacoes) : null,
            'medico'           => $this->relationLoaded('medico') ?
                new SaudeMedicoResource($this->medico) : null,
            'funcionario'      => $this->relationLoaded('funcionario') ?
                new FuncionarioResource($this->funcionario) : null,
        ];
    }

}
