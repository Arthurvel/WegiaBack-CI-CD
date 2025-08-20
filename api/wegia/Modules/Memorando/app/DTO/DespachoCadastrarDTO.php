<?php


namespace Modules\Memorando\app\DTO;

use App\DTOs\BaseDTO;

class DespachoCadastrarDTO extends BaseDTO
{

    public string $id_memorando;
    public string $id_remetente;
    public string $id_destinatario;
    public string $texto;


}
