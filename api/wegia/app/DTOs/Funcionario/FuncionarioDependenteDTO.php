<?php

namespace App\DTOs\Funcionario;

use App\DTOs\Pessoa\PessoaDTO;
use App\Models\Pessoa;

class FuncionarioDependenteDTO
{
    public int $id_dependente;
    public int $id_funcionario;
    public int $id_parentesco;
    public int $id_pessoa;
    public ?array $pessoa;
    public ?array $parentesco;
    public ?array $funcionario;

    public function __construct(
        int $id_dependente,
        int $id_funcionario,
        int $id_parentesco,
        int $id_pessoa,
        ?array $pessoa,
        ?array $parentesco,
        ?array $funcionario,
    ) {
        $this->id_dependente  = $id_dependente;
        $this->id_funcionario = $id_funcionario;
        $this->id_parentesco  = $id_parentesco;
        $this->id_pessoa      = $id_pessoa;
        $this->pessoa         = $pessoa;
        $this->parentesco     = $parentesco;
        $this->funcionario    = $funcionario;
    }

    public static function fromArray(array $dados): self
    {
        return new self( 
            $dados['id_dependente'],
            $dados['id_funcionario'],
            $dados['id_parentesco'],
            $dados['id_pessoa'],
            $dados['pessoa'],
            $dados['parentesco'] ?? null,
            $dados['funcionario'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id_dependente'  => $this->id_dependente,
            'id_funcionario' => $this->id_funcionario,
            'id_parentesco'  => $this->id_parentesco,
            'id_pessoa'      => $this->id_pessoa,
            'pessoa'         => is_null($this->pessoa) ? null : PessoaDTO::fromArray($this->pessoa),
            'funcionario'    => is_null($this->funcionario) ? null : FuncionarioDTO::fromArray($this->funcionario),
            'parentesco'     => $this->parentesco,
        ];
    }
}