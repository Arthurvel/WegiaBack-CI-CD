<?php

namespace Modules\ContribuicaoSocios\app\Interfaces;

use Modules\ContribuicaoSocios\app\DTO\PagamentoCadastrarDTO;
use Modules\ContribuicaoSocios\app\DTO\PagamentoGatewayDTO;

interface PagamentoGatewayInterface
{
    public function criarPix(PagamentoCadastrarDTO $dto, int $id_gateway) : PagamentoGatewayDTO;
    public function criarBoleto(PagamentoCadastrarDTO $dto, int $id_gateway): PagamentoGatewayDTO;
    /**
     * @return PagamentoGatewayDTO[]
     */
    public function criarCarne(PagamentoCadastrarDTO $dto, int $id_gateway): array;
    public function criarCartaoCredito(PagamentoCadastrarDTO $dto, int $id_gateway): PagamentoGatewayDTO;
    public function criarCartaoCreditoRecorrencia(PagamentoCadastrarDTO $dto, int $id_gateway): PagamentoGatewayDTO;

}
