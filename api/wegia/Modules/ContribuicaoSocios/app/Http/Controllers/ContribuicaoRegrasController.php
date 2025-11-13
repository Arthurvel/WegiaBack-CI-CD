<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\ContribuicaoSocios\app\Http\Resources\ContribuicaoRegrasResource;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoRegrasService;

/**
 * @OA\Tag(
 *     name="Contribuição Regras",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class ContribuicaoRegrasController extends BaseController
{

    public ContribuicaoRegrasService $service;

    public function __construct(
        ContribuicaoRegrasService $service
    )
    {

//        $this->middleware(['auth:sanctum', 'ability:criar-almoxarifado-do-material'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/regra/filtro",
     *     summary="Busca todas as regras de contribuicao para usar como filtro",
     *     tags={"Contribuição Regras"},
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

            return $this->sucessoResponse( ContribuicaoRegrasResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
