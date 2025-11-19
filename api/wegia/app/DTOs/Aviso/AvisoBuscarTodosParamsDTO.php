<?php

namespace App\DTOs\Aviso;

use App\DTOs\BaseDTO;

class AvisoBuscarTodosParamsDTO extends BaseDTO
{

    public ?string $ativo = null;
    public ?int $id_pessoa = null;
    public ?string $titulo = null;
    public ?string $nivel = null;
    public int $pagina = 1;
    public int $itensPorPagina = 10;


}
