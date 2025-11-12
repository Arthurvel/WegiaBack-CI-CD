<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class AdocaoAtualizarDTO extends BaseDTO
{

    public ?int $id_pessoa;
    public ?string $data_adocao;

}
