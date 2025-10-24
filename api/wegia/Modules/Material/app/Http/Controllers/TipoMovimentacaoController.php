<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\TipoMovimentacaoBuscarTodosSemPaginacaoParamsDTO;
use Modules\Material\app\DTO\TipoMovimentacaoCadastrarDTO;
use Modules\Material\app\Http\Resources\TipoMovimentacaoResource;
use Modules\Material\app\Services\TipoMovimentacaoService;
use Modules\Material\app\Validations\TipoMovimentacaoBuscarTodosSemPaginacaoParamsValidation;
use Modules\Material\app\Validations\TipoMovimentacaoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Tipo Movimentacacao",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class TipoMovimentacaoController extends BaseController
{

    public TipoMovimentacaoService $service;

    public function __construct(
        TipoMovimentacaoService $service
    )
    {
//        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
//        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/tipo-movimentacao",
     *     summary="Cadastra um tipo de movimentacao",
     *     tags={"Tipo Movimentacacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TipoMovimentacaoCadastrarValidation")
     *      ),
     *     @OA\Response(
     *         response=201,
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
    public function cadastrar(TipoMovimentacaoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = TipoMovimentacaoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/tipo-movimentacao/filtros",
     *     summary="Buscar todas os tipos de movimentacao para filtros",
     *     tags={"Tipo Movimentacacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="tipo",
     *           in="query",
     *           description="tipo de movimentacao",
     *           required=false,
     *           @OA\Schema(enum={"e", "s"})
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
    public function buscarTodosFiltro(TipoMovimentacaoBuscarTodosSemPaginacaoParamsValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = TipoMovimentacaoBuscarTodosSemPaginacaoParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosFiltro($dto);

            return $this->sucessoResponse(TipoMovimentacaoResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
