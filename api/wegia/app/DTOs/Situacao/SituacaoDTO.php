<?php

namespace App\DTOs\Situacao;


class SituacaoDTO
{
    public $id_situacao;
    public $situacoes;

    public function __construct(
        int $id_situacao,
        string $situacoes,
    ) {
        $this->id_situacao = $id_situacao;
        $this->situacoes   = $situacoes;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['id_situacao'],
            $dados['situacoes']
        );
    }

    public function toArray(): array
    {
        return [
            'id_situacao' => $this->id_situacao,
            'situacoes'   => $this->situacoes
        ];
    }
}