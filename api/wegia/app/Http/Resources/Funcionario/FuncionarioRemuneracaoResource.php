<?php

namespace app\Http\Resources\Funcionario;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioRemuneracaoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'idfuncionario_remuneracao'  => $this->idfuncionario_remuneracao,
            'funcionario_id_funcionario' => $this->funcionario_id_funcionario,
            'valor'                      => $this->valor,
            'inicio'                     => $this->inicio
                ? Carbon::parse($this->inicio)->format('d/m/Y')
                : null,
            'fim'                        => $this->fim
                ? Carbon::parse($this->fim)->format('d/m/Y')
                : null,
            'tipo'                       => $this->relationLoaded('remuneracaoTipo')
                ? new FuncionarioRemuneracaoTipoResource($this->remuneracaoTipo)
                : null
        ];
    }

}
