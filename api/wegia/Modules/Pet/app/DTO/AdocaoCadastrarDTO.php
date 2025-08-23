<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class AdocaoCadastrarDTO extends BaseDTO
{

    public int $id_pet;
    public int $id_pessoa;
    public string $data_adocao;

}
