<?php

namespace App\DTOs\Pet;

class AtualizarFichaMedicaDTO
{
    public ?string $castrado;
    public ?string $necessidades_especiais;

    public function __construct(
        ?string $castrado = null,
        ?string $necessidades_especiais = null
    ) {
        $this->castrado = $castrado;
        $this->necessidades_especiais  = $necessidades_especiais;
    }

    public static function fromArray(array $dados): self
    {
        return new self( 
            $dados['castrado'] ?? null,
            $dados['necessidades_especiais'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'castrado' => $this->castrado,
            'necessidades_especiais'  => $this->necessidades_especiais,
        ], function ($valor) {
            return !is_null($valor);
        });
    }
}