<?php

namespace App\DTOs\Funcionario;

use App\Models\Funcionario\FuncionarioListaInfo;

class FuncionarioOutrasInfoDTO
{
    public int $idfunncionario_outrasinfo;
    public int $funcionario_id_funcionario;
    public array $lista_info;
    public string $dado;

    public function __construct(
        int $idfunncionario_outrasinfo,
        int $funcionario_id_funcionario,
        array $lista_info,
        string $dado,
    ) {
        $this->idfunncionario_outrasinfo  = $idfunncionario_outrasinfo;
        $this->funcionario_id_funcionario = $funcionario_id_funcionario;
        $this->lista_info                 = $lista_info;
        $this->dado                       = $dado;
    }

    public static function fromArray(array $dados): self
    {
        return new self( 
            $dados['idfunncionario_outrasinfo'],
            $dados['funcionario_id_funcionario'],
            $dados['lista_info'],
            $dados['dado']
        );
    }

    public function toArray(): array
    {
        return [
            'idfunncionario_outrasinfo' => $this->idfunncionario_outrasinfo,
            'id_funcionario'            => $this->funcionario_id_funcionario,
            'dado'                      => $this->dado,
            'lista_info'                => $this->lista_info,
        ];
    }
}