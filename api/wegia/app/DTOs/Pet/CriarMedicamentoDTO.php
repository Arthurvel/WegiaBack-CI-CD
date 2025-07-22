<?php

namespace App\DTOs\Pet;

use Ramsey\Uuid\Type\Integer;

class CriarMedicamentoDTO
{
    public string $nome_medicamento;
    public string $descricao_medicamento;
    public string $aplicacao;

    public function __construct(
        string $nome_medicamento,
        string $descricao_medicamento,
        string $aplicacao,
    ) {
        $this->nome_medicamento = $nome_medicamento;
        $this->descricao_medicamento = $descricao_medicamento;
        $this->aplicacao = $aplicacao;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['nome_medicamento'],
            $dados['descricao_medicamento'],
            $dados['aplicacao'],
        );
    }

    public function toArray(): array
    {
        return [
            'nome_medicamento' => $this->nome_medicamento,
            'descricao_medicamento' => $this->descricao_medicamento,
            'aplicacao' => $this->aplicacao
        ];
    }

}