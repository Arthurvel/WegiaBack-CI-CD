<?php

namespace App\DTOs\Pet;

use Ramsey\Uuid\Type\Integer;

class CriarMedicacaoDTO
{
    public int $id_medicamento;
    public int $id_pet_atendimento;
    public ?string $data_medicacao;

    public function __construct(
        int $id_medicamento,
        string $id_pet_atendimento,
        ?string $data_medicacao,
    ) {
        $this->id_medicamento = $id_medicamento;
        $this->id_pet_atendimento = $id_pet_atendimento;
        $this->data_medicacao = $data_medicacao;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['id_medicamento'],
            $dados['id_pet_atendimento'],
            $dados['data_medicacao'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_medicamento' => $this->id_medicamento,
            'id_pet_atendimento' => $this->id_pet_atendimento,
            'data_medicacao' => $this->data_medicacao
        ];
    }

}