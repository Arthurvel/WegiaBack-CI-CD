<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class SocioRelatorioBuscarTodosParamsDTO extends BaseDTO
{

    public string $tipo_socio;
    public string $id_status;
    public string $id_tag;
    public string $tipo_pessoa;
    public string $valor_filtro;
    public string $valor;

}
