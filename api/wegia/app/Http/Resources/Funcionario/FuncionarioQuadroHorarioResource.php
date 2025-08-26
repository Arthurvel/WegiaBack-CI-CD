<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioQuadroHorarioResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_quadro_horario' => $this->id_quadro_horario,
            'id_funcionario' => $this->id_funcionario,
            'carga_horaria' => $this->carga_horaria,
            'entrada1' => $this->entrada1,
            'saida1' => $this->saida1,
            'entrada2' => $this->entrada2,
            'saida2' => $this->saida2,
            'total' => $this->total,
            'dias_trabalhados' => $this->dias_trabalhados,
            'folga' => $this->folga,
            'escala' => $this->relationLoaded('quadroHorarioEscala') ? new FuncionarioEscalaResource($this->quadroHorarioEscala) : null,
            'tipo' => $this->relationLoaded('quadroHorarioTipo') ? new FuncionarioQuadroHorarioTipoResource($this->quadroHorarioTipo) : null
        ];
    }

}
