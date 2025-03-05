<?php

namespace App\DTOs\Funcionario;

use Carbon\Carbon;

class FuncionarioDocumentoDTO
{
    public int $id_fundocs;
    public int $id_funcionario;
    public int $id_docfuncional;
    public Carbon $data;
    public string $arquivo;
    public string $nome_arquivo;
    public string $extensao_arquivo;
    public string $nome_docfuncional;
    public ?string $descricao_docfuncional;

    public function __construct(
        int $id_fundocs,
        int $id_funcionario,
        int $id_docfuncional,
        Carbon $data,
        string $arquivo,
        string $nome_arquivo,
        string $extensao_arquivo,
        string $nome_docfuncional,
        ?string $descricao_docfuncional = null
    ) {
        $this->id_fundocs             = $id_fundocs;
        $this->id_funcionario         = $id_funcionario;
        $this->id_docfuncional        = $id_docfuncional;
        $this->data                   = $data;
        $this->arquivo                = $arquivo;
        $this->nome_arquivo           = $nome_arquivo;
        $this->extensao_arquivo       = $extensao_arquivo;
        $this->nome_docfuncional      = $nome_docfuncional;
        $this->descricao_docfuncional = $descricao_docfuncional;
    }

    public static function fromArray(array $dados): self
    {
        return new self( 
            $dados['id_fundocs'],
            $dados['id_funcionario'],
            $dados['id_docfuncional'],
            Carbon::parse($dados['data']),
            $dados['arquivo'],
            $dados['nome_arquivo'],
            $dados['extensao_arquivo'],
            $dados['funcionario_doc_funcional']['nome_docfuncional'],
            $dados['funcionario_doc_funcional']['descricao_docfuncional'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_fundocs'             => $this->id_fundocs,
            'id_funcionario'         => $this->id_funcionario,
            'id_docfuncional'        => $this->id_docfuncional,
            'nome_arquivo'           => $this->nome_arquivo,
            'extensao_arquivo'       => $this->extensao_arquivo,
            'nome_docfuncional'      => $this->nome_docfuncional,
            'descricao_docfuncional' => $this->descricao_docfuncional,
            'data'                   => $this->data->toDateTimeString(),
            'arquivo'                => $this->arquivo,
        ];
    }
}