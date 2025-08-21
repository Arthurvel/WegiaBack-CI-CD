<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class PetFotoCadastrarDTO extends BaseDTO
{
    public string $arquivo_foto_pet;
    public string $arquivo_foto_pet_nome;
    public string $arquivo_foto_pet_extensao;
}
