<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\ContribuicaoSocios\app\Http\Resources\SocioStatusResource;
use Modules\ContribuicaoSocios\app\Services\SocioStatusService;

/**
 * @OA\Tag(
 *     name="Socio Status",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class SocioStatusController extends BaseController
{

    public SocioStatusService $service;

    public function __construct(
        SocioStatusService $service
    )
    {
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/socio/status/filtro",
     *     summary="Busca todas os status dos socios para usar como filtro",
     *     tags={"Socio Status"},
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

            return $this->sucessoResponse( SocioStatusResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
