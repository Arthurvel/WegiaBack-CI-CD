<?php

namespace app\DTOs\Funcionario\Remuneracao;

use App\DTOs\BaseDTO;

class FuncionarioRemuneracaoCadastrarDTO extends BaseDTO
{

    public int $funcionario_id_funcionario;
    public int $funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo;
    public float $valor;
    public string $inicio;
    public string $fim;

}
