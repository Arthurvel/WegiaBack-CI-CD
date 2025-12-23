<?php

namespace Modules\ContribuicaoSocios\app\Services;

use Illuminate\Support\Facades\DB;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoLogCadastrarDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoRecorrenciaDTO;
use Modules\ContribuicaoSocios\app\DTO\PagamentoCadastrarDTO;
use Modules\ContribuicaoSocios\app\Factories\PagamentoGatewayFactory;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoLogRepository;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoMeioDePagamentoRepository;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoRecorrenciaRepository;
use Modules\ContribuicaoSocios\app\Traits\GerarCodigoTrait;

class PagamentoService
{

    use GerarCodigoTrait;

    private ContribuicaoMeioDePagamentoRepository $contribuicaoMeioDePagamentoRepository;
    private ContribuicaoLogRepository $contribuicaoLogRepository;
    private ContribuicaoRecorrenciaRepository $contribuicaoRecorrenciaRepository;
    private PagamentoGatewayFactory $factory;

    public function __construct(
        ContribuicaoMeioDePagamentoRepository $contribuicaoMeioDePagamentoRepository,
        ContribuicaoLogRepository $contribuicaoLogRepository,
        ContribuicaoRecorrenciaRepository $contribuicaoRecorrenciaRepository,
        PagamentoGatewayFactory $factory
    )
    {
        $this->contribuicaoMeioDePagamentoRepository = $contribuicaoMeioDePagamentoRepository;
        $this->contribuicaoLogRepository             = $contribuicaoLogRepository;
        $this->contribuicaoRecorrenciaRepository       = $contribuicaoRecorrenciaRepository;
        $this->factory                               = $factory;
    }

    public function criarPagamento(PagamentoCadastrarDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $meioPagamento = $this->contribuicaoMeioDePagamentoRepository->buscarPorId($dto->id_contribuicao_meioPagamento);
            $gateway = $meioPagamento->gateway;

            $gatewayInstance = $this->factory->make($gateway);

            $pagamento =  match (strtolower($meioPagamento->meio)) {
                'pix'           => $gatewayInstance->criarPix($dto, $gateway->id),
                'boleto'        => $gatewayInstance->criarBoleto($dto, $gateway->id),
                'carne'         => $gatewayInstance->criarCarne($dto, $gateway->id),
                'cartaocredito' => $gatewayInstance->criarCartaoCredito($dto, $gateway->id),
                'recorrencia'   => $gatewayInstance->criarCartaoCreditoRecorrencia($dto, $gateway->id),
                default         => throw new \Exception("Método de pagamento inválido."),
            };

            $contribuicaoLogArrayDTO = [];
            $pagamentos = is_array($pagamento) ? $pagamento : [$pagamento];

            if(strtolower($meioPagamento->meio) != 'recorrencia') {
                foreach ($pagamentos as $p) {

                    $contribuicaoLogArrayDTO[] = ContribuicaoLogCadastrarDTO::fromArray([
                        'id_socio'          => $dto->id_socio,
                        'id_gateway'        => $gateway->id,
                        'id_meio_pagamento' => $dto->id_contribuicao_meioPagamento,
                        'codigo'            => $p->id_pedido,
                        'valor'             => $dto->valor,
                        'data_geracao'      => now()->format('Y-m-d'),
                        'data_vencimento'   => $p->vencimento,
                        'url'               => $p->url_privada
                    ]);
                }

                $this->contribuicaoLogRepository->criarEmMassa($contribuicaoLogArrayDTO);
            } else {
                $contribuicaoRecorrencia = ContribuicaoRecorrenciaDTO::fromArray([
                   'id_socio'          => $dto->id_socio,
                   'id_gateway'        => $gateway->id,
                   'codigo'            => $pagamentos[0]->id_pedido,
                   'valor'             => $dto->valor,
                   'data_inicio'      => now()->format('Y-m-d'),
                ]);
                $this->contribuicaoRecorrenciaRepository->criar($contribuicaoRecorrencia);
            }

            return $pagamentos;
        });
    }

}
