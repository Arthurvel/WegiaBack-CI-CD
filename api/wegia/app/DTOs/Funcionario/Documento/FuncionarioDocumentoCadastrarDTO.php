<?php

namespace app\DTOs\Funcionario\Documento;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class FuncionarioDocumentoCadastrarDTO extends BaseDTO
{

    public UploadedFile $arquivo;
    public int $id_docfuncional;
    public int $id_funcionario;

}
