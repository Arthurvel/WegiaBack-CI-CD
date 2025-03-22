<?php

namespace App\DTOs\Funcionario;

class FuncionarioQuadroHorarioDTO
{
    public int $id_quadro_horario;
    public int $id_funcionario;
    public string $carga_horaria;
    public string $entrada1;
    public string $saida1;
    public string $entrada2;
    public string $saida2;
    public string $total;
    public string $dias_trabalhados;
    public string $folga;
    public array $escala;
    public array $tipo;

    public function __construct(
        int $id_quadro_horario,
        int $id_funcionario,
        array $escala,
        array $tipo,
        string $carga_horaria,
        string $entrada1,
        string $saida1,
        string $entrada2,
        string $saida2,
        string $total, 
        string $dias_trabalhados,
        string $folga 
    ) {
        $this->id_quadro_horario = $id_quadro_horario;
        $this->id_funcionario    = $id_funcionario;
        $this->escala            = $escala;
        $this->tipo              = $tipo;
        $this->carga_horaria     = $carga_horaria;
        $this->entrada1          = $entrada1;
        $this->saida1            = $saida1;
        $this->entrada2          = $entrada2;
        $this->saida2            = $saida2;
        $this->total             = $total;
        $this->dias_trabalhados  = $dias_trabalhados;
        $this->folga             = $folga;
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            $dados['id_quadro_horario'],
            $dados['id_funcionario'],
            $dados['quadro_horario_tipo'],
            $dados['quadro_horario_escala'],
            $dados['carga_horaria'] ?? null,
            $dados['entrada1'] ?? null,
            $dados['saida1'] ?? null,
            $dados['entrada2'] ?? null,
            $dados['saida2'] ?? null,
            $dados['total'] ?? null,
            $dados['dias_trabalhados'] ?? null,
            $dados['folga'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_quadro_horario' => $this->id_quadro_horario,
            'id_funcionario'    => $this->id_funcionario,
            'carga_horaria'     => $this->carga_horaria,
            'entrada1'          => $this->entrada1,
            'saida1'            => $this->saida1,
            'entrada2'          => $this->entrada2,
            'saida2'            => $this->saida2,
            'total'             => $this->total,
            'dias_trabalhados'  => $this->dias_trabalhados,
            'folga'             => $this->folga,
            'escala'            => $this->escala,
            'tipo'              => $this->tipo,
        ];
    }
}