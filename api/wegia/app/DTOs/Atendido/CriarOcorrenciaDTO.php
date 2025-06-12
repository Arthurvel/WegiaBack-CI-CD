<?php

namespace App\DTOs\Atendido;

use Carbon\Carbon;

class CriarOcorrenciaDTO
{
    public int $atendido_idatendido;
    public int $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos;
    public int $funcionario_id_funcionario;
    public string $data;
    public string $descricao;

    public function __construct(
        int $atendido_idatendido,
        int $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos,
        int $funcionario_id_funcionario,
        string $data,
        string $descricao,
    ) {
        $this->atendido_idatendido                                   = $atendido_idatendido;
        $this->atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos = $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos;
        $this->funcionario_id_funcionario                            = $funcionario_id_funcionario;
        $this->data                                                  = $data;
        $this->descricao                                             = $descricao;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['atendido_idatendido'],
            $dados['atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'],
            $dados['funcionario_id_funcionario'],
            $dados['data'],
            $dados['descricao'],
        );
    }

    public function toArray(): array
    {
        return [
            'atendido_idatendido'                                   => $this->atendido_idatendido,
            'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos' => $this->atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos,
            'funcionario_id_funcionario'                            => $this->funcionario_id_funcionario,
            'data'                                                  => $this->data,
            'descricao'                                             => $this->descricao

        ];
    }
}