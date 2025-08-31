<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioQuadroHorarioTipoResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id_tipo' => $this->id_tipo,
            'descricao' => $this->descricao,
        ];
    }

}
