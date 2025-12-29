<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarTodosParamsDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoLogCadastrarDTO;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoLogRepository;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoRecorrenciaRepository;

class ContribuicaoLogService extends BaseService
{

    private ContribuicaoRecorrenciaRepository $recorrenciaRepository;

    public function __construct
    (
        ContribuicaoLogRepository $repository,
        ContribuicaoRecorrenciaRepository $recorrenciaRepository,
    )
    {
        parent::__construct($repository);
        $this->recorrenciaRepository = $recorrenciaRepository;
    }


    public function buscarTodasPaginado(ContribuicaoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodasPaginado($dto);
    }

    public function atualizarPagamento(object $data)
    {
        if($data->subscription) {
            DB::transaction(function () use ($data) {

                $recorrencia = $this->recorrenciaRepository->buscarPorCodigo($data->subscription->id);

                $contribuicaoLogCadastrarDTO = ContribuicaoLogCadastrarDTO::fromArray([
                    'id_socio'          => $recorrencia->id_socio,
                    'id_gateway'        => $recorrencia->id,
                    'id_meio_pagamento' => 5,
                    'id_recorrencia'    => $recorrencia->id,
                    'codigo'            => null,
                    'valor'             => $recorrencia->valor,
                    'data_geracao'      => now()->format('Y-m-d'),
                    'data_vencimento'   => now()->format('Y-m-d'),
                    'data_pagamento'    => now()->format('Y-m-d'),
                    'status_pagamento'  => true,

                ]);

                return $this->repository->criar($contribuicaoLogCadastrarDTO);

            });
        } else {
            return $this->repository->atualizarPagamento($data->id);
        }
    }

    public function buscarContribuicoesSegundaVia(string $documento)
    {
        return $this->repository->buscarContribuicoesSegundaVia($documento);
    }


}
