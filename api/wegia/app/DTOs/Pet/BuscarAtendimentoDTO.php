<?php

namespace App\DTOs\Pet;

use Ramsey\Uuid\Type\Integer;

class BuscarAtendimentoDTO
{
    public int $id_pet_atendimento;
    public int $id_ficha_medica;
    public string $data_atendimento;
    public ?string $descricao;

    public function __construct(
        int $id_pet_atendimento,
        int $id_ficha_medica,
        string $data_atendimento,
        ?string $descricao,
    ) {
        $this->id_pet_atendimento = $id_pet_atendimento;
        $this->id_ficha_medica = $id_ficha_medica;
        $this->data_atendimento = $data_atendimento;
        $this->descricao = $descricao;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['id_pet_atendimento'],
            $dados['id_ficha_medica'],
            $dados['data_atendimento'],
            $dados['descricao'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_pet_atendimento' => $this->id_pet_atendimento,
            'id_ficha_medica' => $this->id_ficha_medica,
            'data_atendimento' => $this->data_atendimento,
            'descricao' => $this->descricao
        ];
    }

}