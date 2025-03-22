<?php

namespace App\DTOs\Funcionario;

class CadastrarQuadroHorarioDTO
{
    public int $id_funcionario;
    public int $escala;
    public int $tipo;
    public ?string $carga_horaria;
    public ?string $entrada1;
    public ?string $saida1;
    public ?string $entrada2;
    public ?string $saida2;
    public ?string $total;
    public ?string $dias_trabalhados;
    public ?string $folga;

    public function __construct(
        int $id_funcionario,
        int $escala,
        int $tipo,
        ?string $carga_horaria = null,
        ?string $entrada1 = null,
        ?string $saida1 = null,
        ?string $entrada2 = null,
        ?string $saida2 = null,
        ?string $total = null,
        ?string $dias_trabalhados = null,
        ?string $folga = null
    ) {
        $this->id_funcionario   = $id_funcionario;
        $this->escala           = $escala;
        $this->tipo             = $tipo;
        $this->carga_horaria    = $carga_horaria;
        $this->entrada1         = $entrada1;
        $this->saida1           = $saida1;
        $this->entrada2         = $entrada2;
        $this->saida2           = $saida2;
        $this->total            = $total;
        $this->dias_trabalhados = $dias_trabalhados;
        $this->folga            = $folga;
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            $dados['id_funcionario'],
            $dados['escala'],
            $dados['tipo'],
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
            'id_funcionario'   => $this->id_funcionario,
            'escala'           => $this->escala,
            'tipo'             => $this->tipo,
            'carga_horaria'    => $this->carga_horaria,
            'entrada1'         => $this->entrada1,
            'saida1'           => $this->saida1,
            'entrada2'         => $this->entrada2,
            'saida2'           => $this->saida2,
            'total'            => $this->total,
            'dias_trabalhados' => $this->dias_trabalhados,
            'folga'            => $this->folga,
        ];
    }
}