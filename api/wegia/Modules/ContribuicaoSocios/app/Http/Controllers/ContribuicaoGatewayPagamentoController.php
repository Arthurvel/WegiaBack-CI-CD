<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\ContribuicaoSocios\app\Http\Resources\ContribuicaoGatewayPagamentoResource;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoGatewayPagamentoService;
/**
 * @OA\Tag(
 *     name="Contribuição Gateway",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class ContribuicaoGatewayPagamentoController extends BaseController
{

    public ContribuicaoGatewayPagamentoService $service;

    public function __construct(
        ContribuicaoGatewayPagamentoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-meio-de-pagamento-de-contribuicao'])->only(['buscarTodosParaFiltro']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/gateway/filtro",
     *     summary="Busca todos os Gateway de pagamento para usar como filtro",
     *     tags={"Contribuição Gateway"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarTodosParaFiltro()
    {
        try {
            $buscados = $this->service->buscarTodos();

            return $this->sucessoResponse( ContribuicaoGatewayPagamentoResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
