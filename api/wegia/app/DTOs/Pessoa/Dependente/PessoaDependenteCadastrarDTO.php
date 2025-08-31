<?php

namespace app\DTOs\Pessoa\Dependente;

use App\DTOs\BaseDTO;

class PessoaDependenteCadastrarDTO extends BaseDTO
{

    public int $id_pessoa;
    public int $id_dependente_pessoa;
    public string $parentesco;

}
