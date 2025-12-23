<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class PagamentoGatewayDTO extends BaseDTO
{

    public string $url;
    public string $imagem;
    public string $id_pedido;
    public string $metodo;
    public string $vencimento;
    public ?string $url_privada = null;


}
