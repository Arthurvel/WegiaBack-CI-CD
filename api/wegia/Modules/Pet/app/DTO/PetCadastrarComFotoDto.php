<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class PetCadastrarComFotoDto extends BaseDTO
{
    public string $nome;
    public string $data_nascimento;
    public string $data_acolhimento;
    public string $sexo;
    public ?string $caracteristicas_especificas = null;
    public ?UploadedFile $foto;
    public int $id_pet_especie;
    public int $id_pet_raca;
    public string $cor;


}
