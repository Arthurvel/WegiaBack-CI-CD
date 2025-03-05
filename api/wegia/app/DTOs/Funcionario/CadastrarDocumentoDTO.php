<?php

namespace App\DTOs\Funcionario;

class CadastrarDocumentoDTO
{
    public int $id_funcionario;
    public int $id_docfuncional;
    public string $extensao_arquivo;
    public string $nome_arquivo;
    public string $arquivo;

    public function __construct(
        int $id_funcionario,
        int $id_docfuncional,
        string $extensao_arquivo,
        string $nome_arquivo,
        string $arquivo
    ) {
        $this->id_funcionario   = $id_funcionario;
        $this->id_docfuncional  = $id_docfuncional;
        $this->extensao_arquivo = $extensao_arquivo;
        $this->nome_arquivo     = $nome_arquivo;
        $this->arquivo          = $arquivo;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['id_funcionario'],
            $dados['id_docfuncional'],
            $dados['extensao_arquivo'],
            $dados['nome_arquivo'],
            $dados['arquivo']
        );
    }

    public function toArray(): array
    {
        return [
            'id_funcionario'   => $this->id_funcionario,
            'id_docfuncional'  => $this->id_docfuncional,
            'extensao_arquivo' => $this->extensao_arquivo,
            'nome_arquivo'     => $this->nome_arquivo,
            'arquivo'          => $this->arquivo
        ];
    }
}