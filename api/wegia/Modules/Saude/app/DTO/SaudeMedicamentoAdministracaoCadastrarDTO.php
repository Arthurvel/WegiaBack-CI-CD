<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeMedicamentoAdministracaoCadastrarDTO extends BaseDTO
{

    public string $aplicacao;
    public int $saude_medicacao_id_medicacao;
    public int $funcionario_id_funcionario;

}
