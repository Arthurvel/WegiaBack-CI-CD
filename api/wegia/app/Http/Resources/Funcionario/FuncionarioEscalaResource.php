<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioEscalaResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id_escala' => $this->id_escala,
            'descricao' => $this->descricao,
        ];
    }

}
