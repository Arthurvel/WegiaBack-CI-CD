<?php

namespace App\DTOs\Pessoa;

use App\Models\Pessoa\PessoaParentescoEnum;

class CadastrarPessoaDependenteDTO
{
    public int $id_pessoa;
    public int $id_dependente_pessoa;
    public PessoaParentescoEnum $parentesco;

    public function __construct(
        int $id_pessoa,
        int $id_dependente_pessoa,
        PessoaParentescoEnum|string $parentesco
    ) {
        $this->id_pessoa = $id_pessoa;
        $this->id_dependente_pessoa = $id_dependente_pessoa;
        $this->parentesco = is_string($parentesco)
            ? PessoaParentescoEnum::tryFrom($parentesco)
            : $parentesco;
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            $dados['id_pessoa'],
            $dados['id_dependente_pessoa'],
            $dados['parentesco']
        );
    }

    public function toArray(): array
    {
        return [
            'id_pessoa' => $this->id_pessoa,
            'id_dependente_pessoa' => $this->id_dependente_pessoa,
            'parentesco' => $this->parentesco->value,
        ];
    }
}
