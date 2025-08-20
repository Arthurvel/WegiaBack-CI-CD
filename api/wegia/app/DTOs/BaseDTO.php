<?php

namespace App\DTOs;

class BaseDTO
{
    public function __construct(array $dados = [])
    {
        foreach ($dados as $chave => $valor) {
            if (property_exists($this, $chave)) {
                $this->{$chave} = $valor;
            }
        }
    }

    public static function fromArray(array $dados): static
    {
        return new static($dados);
    }

    public function toArray(): array
    {
        $propriedades = get_object_vars($this);
        return $propriedades;
    }

    public function toArrayUpdate(): array
    {
        $propriedades = get_object_vars($this);

        return array_filter($propriedades, function ($valor) {
            return !is_null($valor);
        });
    }

}
