<?php

namespace app\DTOs\Funcionario\Documento;

use App\DTOs\BaseDTO;

class FuncionarioDocumentoCadastrarComUrlDTO extends BaseDTO
{

    public string $arquivo;
    public string $nome_arquivo;
    public string $extensao_arquivo;
    public int $id_docfuncional;
    public int $id_funcionario;

}
