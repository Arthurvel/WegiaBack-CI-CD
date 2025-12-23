<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\ContribuicaoSocios\app\Http\Resources\StatusTipoResource;
use Modules\ContribuicaoSocios\app\Services\SocioTipoService;

/**
 * @OA\Tag(
 *     name="Socio Tipo",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class SocioTipoController extends BaseController
{

    public SocioTipoService $service;

    public function __construct(
        SocioTipoService $service
    )
    {
        //$this->middleware(['auth:sanctum', 'ability:criar-regras-de-pagamento-de-contribuicao'])->only(['buscarTodosParaFiltro']);
        $this->middleware(['auth:sanctum'])->except(['buscarTodosParaFiltro']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/socio/tipo/filtro",
     *     summary="Busca todas os tipos dos socios para usar como filtro",
     *     tags={"Socio Tipo"},
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

            return $this->sucessoResponse( StatusTipoResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
