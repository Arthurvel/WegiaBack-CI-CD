<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioRemuneracaoTipoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id_funcionario_remuneracao_tipo' => $this->id_funcionario_remuneracao_tipo,
            'descricao'                       => $this->descricao
        ];
    }

}
