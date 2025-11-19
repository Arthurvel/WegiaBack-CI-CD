<?php

namespace app\DTOs\Pessoa\Dependente;

use App\DTOs\BaseDTO;

class PessoaDependenteBuscarTodosPorIdDTO extends BaseDTO
{
    public int $id_pessoa;
    public string $buscar;
    public string $ordenacao;
    public string $tipoOrdenacao;
    public string $with;
    public int $itensPorPagina;
    public int $pagina;
}
