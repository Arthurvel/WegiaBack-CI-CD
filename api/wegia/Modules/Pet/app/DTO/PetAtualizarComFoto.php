<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class PetAtualizarComFoto extends BaseDTO
{
    public ?string $nome = null;
    public ?string $data_nascimento = null;
    public ?string $data_acolhimento = null;
    public ?string $sexo = null;
    public ?string $caracteristicas_especificas = null;
    public ?UploadedFile $foto = null;
    public ?int $id_pet_especie = null;
    public ?int $id_pet_raca = null;
    public ?string $cor = null;
}
