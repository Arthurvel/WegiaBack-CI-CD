<?php

namespace App\DTOs\Pet;

use Ramsey\Uuid\Type\Integer;

class CriarFichaMedicaDTO
{
    public $castrado;
    public $necessidades_especiais;
    public $id_pet;

    public function __construct(
        string $castrado,
        string $necessidades_especiais,
        int $id_pet,
    ) {
        $this->castrado = $castrado;
        $this->necessidades_especiais = $necessidades_especiais;
        $this->id_pet = $id_pet;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['castrado'],
            $dados['necessidades_especiais'],
            $dados['id_pet'],
        );
    }

    public function toArray(): array
    {
        return [
            'castrado' => $this->castrado,
            'necessidades_especiais' => $this->necessidades_especiais,
            'id_pet' => $this->id_pet
        ];
    }

}