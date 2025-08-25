<?php

namespace app\Http\Resources\Funcionario;

use App\Http\Resources\Pessoa\PessoaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioDependenteResource extends JsonResource
{

    public function toArray($request) {
        return [
            'id_dependente'  => $this->id_dependente,
            'id_funcionario' => $this->id_funcionario,
            'id_pessoa'      => $this->id_pessoa,
            'id_parentesco'  => $this->id_parentesco,
            'parentesco'     => $this->relationLoaded('parentesco')
                ? new FuncionarioParentescoResource($this->parentesco) : null,
            'pessoa'         => $this->relationLoaded('pessoa')
                ? new PessoaResource($this->pessoa) : null
        ];
    }

}
