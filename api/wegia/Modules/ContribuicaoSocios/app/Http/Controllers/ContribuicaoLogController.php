<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarTodosParamsDTO;
use Modules\ContribuicaoSocios\app\Http\Resources\ContribuicaoLogResource;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoLogService;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoRegrasService;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoBuscarTodosParamsValidation;

/**
 * @OA\Tag(
 *     name="Contribuicao",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class ContribuicaoLogController extends BaseController
{

    public ContribuicaoLogService $service;

    public function __construct(
        ContribuicaoLogService $service
    )
    {

        $this->middleware(['auth:sanctum', 'ability:visualizar-as-contribuicoes'])->only(['buscarTodasPaginado']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/contribuicao",
     *     summary="Busca todas contribuicoes paginadas",
     *     tags={"Contribuição"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Texto para busca por nome",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Quantidade de itens por página",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="pagina",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenação",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"nome", "plataforma", "meio_pagamento", "data_geracao", "data_vencimento", "data_pagamento", "valor", "status_pagamento"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tipoOrdenacao",
     *         in="query",
     *         description="Tipo de ordenação",
     *         required=false,
     *         @OA\Schema(type="string", enum={"ASC", "DESC"})
     *     ),
     *     @OA\Parameter(
     *         name="periodo",
     *         in="query",
     *         description="Número de dias para filtrar contribuições (busca últimos X dias)",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="id_socio",
     *         in="query",
     *         description="ID do sócio",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status da contribuição (0=Inativo, 1=Ativo)",
     *         required=false,
     *         @OA\Schema(type="integer", enum={0, 1})
     *     ),
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
    public function buscarTodasPaginado(ContribuicaoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContribuicaoBuscarTodosParamsDTO::fromArray($validated);

            $buscados = $this->service->buscarTodasPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource ($buscados, ContribuicaoLogResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
