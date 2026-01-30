<?php

namespace app\DTOs\Configuracao;

use App\DTOs\BaseDTO;

class TabelaImagemCampoCadastrarOuAtualizarDTO extends BaseDTO
{

    public int $id_imagem;
    public int $id_campo;

}
