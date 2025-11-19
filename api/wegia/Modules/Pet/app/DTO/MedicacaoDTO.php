<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class MedicacaoDTO extends BaseDTO
{
    public int $id_medicamento;
    public int $id_pet_atendimento;
    public string $data_medicacao;
}
