<?php

namespace App\DTOs\Atendido;

use App\DTOs\Pessoa\PessoaDTO;
use App\Models\Atendido\AtendidoStatus;
use App\Models\Atendido\AtendidoTipo;
use App\Models\Pessoa;

class AtendidoDTO
{
    public int $idatendido;
    public int $pessoa_id_pessoa;
    public int $atendido_tipo_idatendido_tipo;
    public int $atendido_status_idatendido_status;
    public ?array $pessoa;
    public ?array $tipo;
    public ?array $status;

    public function __construct(
        int $idatendido,
        int $pessoa_id_pessoa,
        int $atendido_tipo_idatendido_tipo,
        int $atendido_status_idatendido_status,
        ?array $pessoa = null,
        ?array $tipo = null,
        ?array $status = null 
    ) {
        $this->idatendido                        = $idatendido;
        $this->pessoa_id_pessoa                  = $pessoa_id_pessoa;
        $this->atendido_tipo_idatendido_tipo     = $atendido_tipo_idatendido_tipo;
        $this->atendido_status_idatendido_status = $atendido_status_idatendido_status;
        $this->pessoa                            = $pessoa;
        $this->tipo                              = $tipo;
        $this->status                            = $status;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['idatendido'],
            $dados['pessoa_id_pessoa'],
            $dados['atendido_tipo_idatendido_tipo'],
            $dados['atendido_status_idatendido_status'],
            isset($dados['pessoa']) ? $dados['pessoa'] : null,
            isset($dados['atendido_tipo']) ? $dados['atendido_tipo'] : null,
            isset($dados['atendido_status']) ? $dados['atendido_status'] : null
        );
    }

    public function toArray(): array
    {
        return [
            'idatendido'                        => $this->idatendido,
            'pessoa_id_pessoa'                  => $this->pessoa_id_pessoa,
            'atendido_tipo_idatendido_tipo'     => $this->atendido_tipo_idatendido_tipo,
            'atendido_status_idatendido_status' => $this->atendido_status_idatendido_status,
            'pessoa'                            => $this->pessoa ? PessoaDTO::fromArray($this->pessoa)->toArray() : null,
            'tipo'                              => $this->tipo ? $this->tipo : null,
            'status'                            => $this->status ? $this->status : null,
        ];
    }
}