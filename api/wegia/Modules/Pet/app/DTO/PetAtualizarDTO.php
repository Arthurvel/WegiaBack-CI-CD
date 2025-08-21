<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class PetAtualizarDTO extends BaseDTO
{
    public ?string $nome = null;
    public ?string $data_nascimento = null;
    public ?string $data_acolhimento = null;
    public ?string $sexo = null;
    public ?string $caracteristicas_especificas = null;
    public ?int $id_pet_foto = null;
    public ?int $id_pet_especie = null;
    public ?int $id_pet_raca = null;
    public ?string $cor = null;
}
