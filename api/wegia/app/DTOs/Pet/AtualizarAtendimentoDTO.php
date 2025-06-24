<?php

namespace App\DTOs\Pet;

use Ramsey\Uuid\Type\Integer;

class AtualizarAtendimentoDTO
{
    public ?string $data_atendimento ;
    public ?string $descricao;

    public function __construct(
        ?string $data_atendimento,
        ?string $descricao,
    ) {
        $this->data_atendimento = $data_atendimento;
        $this->descricao = $descricao;
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            $dados['data_atendimento'] ?? null,
            $dados['descricao'] ?? null,
        );
    }
    public function toArray(): array
    {
        return array_filter([
            'data_atendimento' => $this->data_atendimento,
            'descricao' => $this->descricao,
        ], function ($valor) {
            return !is_null($valor);
        });
    }
}