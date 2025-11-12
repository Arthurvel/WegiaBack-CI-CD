<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeMedicacaoCadastrarDTO extends BaseDTO
{

    public int $id_atendimento;
    public string $medicamento;
    public ?string $dosagem;
    public ?string $horario;
    public ?string $duracao;


}
