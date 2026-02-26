<?php

namespace app\DTOs\Funcionario\QuadroHorario;

use App\DTOs\BaseDTO;

class FuncionarioQuadroHorarioCadastrarDTO extends BaseDTO
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
}
