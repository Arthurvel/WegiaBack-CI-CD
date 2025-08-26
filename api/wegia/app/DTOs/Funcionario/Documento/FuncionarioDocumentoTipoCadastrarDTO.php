<?php

namespace app\DTOs\Funcionario\Documento;

use App\DTOs\BaseDTO;

class FuncionarioDocumentoTipoCadastrarDTO extends BaseDTO
{

    public string $nome_docfuncional;
    public ?string $descricao_docfuncional;

}
