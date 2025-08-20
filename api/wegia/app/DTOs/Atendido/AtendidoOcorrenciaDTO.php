<?php

namespace App\DTOs\Atendido;

use Carbon\Carbon;

class AtendidoOcorrenciaDTO
{
    public int $idatendido_ocorrencias;
    public int $atendido_idatendido;
    public int $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos;
    public int $funcionario_id_funcionario;
    public string $data;
    public string $descricao;
    public ?array $tipos;
    public ?array $documento;

    public function __construct(
        int $idatendido_ocorrencias,
        int $atendido_idatendido,
        int $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos,
        int $funcionario_id_funcionario,
        string $data,
        string $descricao,
        ?array $tipos,
        ?array $documento
    ) {
        $this->idatendido_ocorrencias                                = $idatendido_ocorrencias;
        $this->atendido_idatendido                                   = $atendido_idatendido;
        $this->atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos = $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos;
        $this->funcionario_id_funcionario                            = $funcionario_id_funcionario;
        $this->data                                                  = $data;
        $this->descricao                                             = $descricao;
        $this->tipos                                                 = $tipos;
        $this->documento                                             = $documento;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['idatendido_ocorrencias'],
            $data['atendido_idatendido'],
            $data['atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'],
            $data['funcionario_id_funcionario'],
            $data['data'],
            $data['descricao'],
            $data['tipos'] ?? null,
            $data['documento'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'idatendido_ocorrencias'                                 => $this->idatendido_ocorrencias,
            'atendido_idatendido'                                   => $this->atendido_idatendido,
            'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos' => $this->atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos,
            'funcionario_id_funcionario'                            => $this->funcionario_id_funcionario,
            'data'                                                  => Carbon::parse($this->data)->format('d/m/Y') ?? null,
            'descricao'                                             => $this->descricao,
            'tipos'                                                 => $this->tipos,
            'documento'                                            => $this->documento ? AtendidoOcorrenciaDocDTO::fromArray($this->documento)->toArray() : null,
        ];
    }
}
