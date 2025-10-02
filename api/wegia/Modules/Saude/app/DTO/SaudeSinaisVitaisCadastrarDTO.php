<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeSinaisVitaisCadastrarDTO extends BaseDTO
{

    public int $id_fichamedica;
    public int $id_funcionario;
    public string $data;
    public ?float $saturacao = null;
    public ?string $pressao_arterial = null;
    public ?int $frequencia_cardiaca = null;
    public ?int $frequencia_respiratoria = null;
    public ?float $temperatura = null;
    public ?float $hgt = null;

}
