<?php

namespace App\DTOs\Funcionario;

class CadastrarDependenteFuncionarioDTO
{
    public int $id_funcionario;
    public int $id_pessoa;
    public int $id_parentesco;

    public function __construct(
        int $id_funcionario,
        int $id_pessoa,
        int $id_parentesco
    ) {
        $this->id_funcionario = $id_funcionario;
        $this->id_pessoa      = $id_pessoa;
        $this->id_parentesco  = $id_parentesco;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['id_funcionario'],
            $dados['id_pessoa'],
            $dados['id_parentesco']
        );
    }

    public function toArray(): array
    {
        return [
            'id_funcionario' => $this->id_funcionario,
            'id_pessoa'      => $this->id_pessoa,
            'id_parentesco'  => $this->id_parentesco
        ];
    }
}