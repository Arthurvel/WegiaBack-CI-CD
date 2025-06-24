<?php

namespace App\DTOs\Funcionario;

class FuncionarioRemuneracaoTipoDTO
{
    public int $id_funcionario_remuneracao_tipo;
    public string $descricao;

    public function __construct(
        int $idfuncionario_remuneracao_tipo,
        string $descricao
    ) {
        $this->id_funcionario_remuneracao_tipo = $idfuncionario_remuneracao_tipo;
        $this->descricao                      = $descricao;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['idfuncionario_remuneracao_tipo'],
            $dados['descricao']
        );
    }

    public function toArray(): array
    {
        return [
            'id_funcionario_remuneracao_tipo' => $this->id_funcionario_remuneracao_tipo,
            'descricao'                       => $this->descricao
        ];
    }
}