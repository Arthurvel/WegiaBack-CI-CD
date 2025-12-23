<?php

namespace Modules\ContribuicaoSocios\app\Factories;

use Modules\ContribuicaoSocios\app\Interfaces\PagamentoGatewayInterface;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoGatewayPagamento;
use Modules\ContribuicaoSocios\app\Services\Gateways\PagarMeGateway;

class PagamentoGatewayFactory
{

    public static function make(ContribuicaoGatewayPagamento $gateway): PagamentoGatewayInterface
    {
        $nome = strtolower(str_replace(' ', '', $gateway['plataforma']));

        return match ($nome) {
            'pagarme' => new PagarMeGateway(
                secretKey: config('contribuicaosocios.gateways.pagarme.private_key'),
                baseUrl: config('contribuicaosocios.gateways.pagarme.base_url'),
            ),

            default => throw new \Exception("Gateway não implementado: $gateway")
        };
    }

}
