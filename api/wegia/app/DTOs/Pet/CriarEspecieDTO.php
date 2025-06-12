<?php

namespace App\DTOs\Pet;


class CriarEspecieDTO
{
    public $descricao;


    public function __construct(
        string $descricao,
    ) {
        $this->descricao = $descricao;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['descricao'],
        );
    }

    public function toArray(): array
    {
        return [
            'descricao' => $this->descricao
        ];
    }
}