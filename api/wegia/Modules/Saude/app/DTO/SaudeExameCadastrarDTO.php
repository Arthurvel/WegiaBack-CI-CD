<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class SaudeExameCadastrarDTO extends BaseDTO
{

    public int $id_fichamedica;
    public int $id_exame_tipo;
    public string $data;
    public UploadedFile $arquivo;

}
