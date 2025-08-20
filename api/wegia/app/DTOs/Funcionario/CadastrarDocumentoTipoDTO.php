<?php

namespace App\DTOs\Funcionario;

class CadastrarDocumentoTipoDTO
{
    public string $nome_docfuncional;
    public ?string $descricao_docfuncional;

    public function __construct(
        string $nome_docfuncional,
        string $descricao_docfuncional,
    ) {
        $this->nome_docfuncional      = $nome_docfuncional;
        $this->descricao_docfuncional = $descricao_docfuncional;
    }

    public static function fromArray(array $dados): self
    {
        return new self( 
            $dados['nome_docfuncional'],
            $dados['descricao_docfuncional']
        );
    }

    public function toArray(): array
    {
        return [
            'nome_docfuncional'      => $this->nome_docfuncional,
            'descricao_docfuncional' => $this->descricao_docfuncional
        ];
    }
}