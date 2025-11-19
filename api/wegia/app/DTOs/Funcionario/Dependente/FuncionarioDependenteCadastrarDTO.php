<?php

namespace app\DTOs\Funcionario\Dependente;

use App\DTOs\BaseDTO;

class FuncionarioDependenteCadastrarDTO extends BaseDTO
{

    public int $id_funcionario;
    public int $id_pessoa;
    public int $id_parentesco;

}
