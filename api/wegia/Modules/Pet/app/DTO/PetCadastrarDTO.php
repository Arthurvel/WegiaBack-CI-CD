<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class PetCadastrarDTO extends BaseDTO
{
    public string $nome;
    public string $data_nascimento;
    public string $data_acolhimento;
    public string $sexo;
    public ?string $caracteristicas_especificas = null;
    public ?string $id_pet_foto = null;
    public int $id_pet_especie;
    public int $id_pet_raca;
    public string $cor;


}
