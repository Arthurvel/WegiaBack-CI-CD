<?php

namespace App\DTOs\Cargo;


class CargoDTO
{
    public $id_cargo;
    public $cargo;

    public function __construct(
        int $id_cargo,
        string $cargo,
    ) {
        $this->id_cargo = $id_cargo;
        $this->cargo    = $cargo;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['id_cargo'],
            $dados['cargo']
        );
    }

    public function toArray(): array
    {
        return [
            'id_cargo' => $this->id_cargo,
            'cargo'    => $this->cargo
        ];
    }
}