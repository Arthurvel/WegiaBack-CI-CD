<?php

namespace App\DTOs\Pessoa;

class PessoaDependenteDTO
{
    public int $id_dependente;
    public int $id_pessoa;
    public int $id_dependente_pessoa;
    public string $parentesco;
    public ?array $titular;
    public ?array $dependente;

    public function __construct(
        int $id_dependente,
        int $id_pessoa,
        int $id_dependente_pessoa,
        string $parentesco,
        ?array $titular,
        ?array $dependente
    ) {
        $this->id_dependente        = $id_dependente;
        $this->id_pessoa            = $id_pessoa;
        $this->id_dependente_pessoa = $id_dependente_pessoa;
        $this->parentesco           = $parentesco;
        $this->titular              = $titular;
        $this->dependente           = $dependente;
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            $dados['id_dependente'],
            $dados['id_pessoa'],
            $dados['id_dependente_pessoa'],
            $dados['parentesco'],
            $dados['titular'] ?? null,
            $dados['dependente'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_dependente'        => $this->id_dependente,
            'id_pessoa'            => $this->id_pessoa,
            'id_dependente_pessoa' => $this->id_dependente_pessoa,
            'parentesco'           => $this->parentesco,
            'titular'              => PessoaDTO::fromArray($this->titular)->toArray(),
            'dependente'           => PessoaDTO::fromArray($this->dependente)->toArray(),
        ];
    }
}