<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\TipoMovimentacaoAtualizacaoDTO;
use Modules\Material\app\DTO\TipoMovimentacaoBuscarTodosParamsDTO;
use Modules\Material\app\DTO\TipoMovimentacaoBuscarTodosSemPaginacaoParamsDTO;
use Modules\Material\app\DTO\TipoMovimentacaoCadastrarDTO;
use Modules\Material\app\Http\Resources\TipoMovimentacaoResource;
use Modules\Material\app\Services\TipoMovimentacaoService;
use Modules\Material\app\Validations\TipoMovimentacaoAtualizacaoValidation;
use Modules\Material\app\Validations\TipoMovimentacaoBuscarTodosParamsValidation;
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

        $this->middleware(['auth:sanctum', 'ability:criar-tipo-de-movimentacao-do-material'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-tipo-de-movimentacao-do-material'])->only(['buscarTodosPaginado']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-tipo-de-movimentacao-do-material'])->only(['atualizar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-relatorio-material,criar-entrada-de-material,criar-saida-de-material'])->only(['buscarTodosFiltro']);
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
     * @OA\Put(
     *     path="/material/tipo-movimentacao/{id}",
     *     summary="Atualizar o tipo de movimentacacao",
     *     tags={"Tipo Movimentacacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do tipo de movimentacao",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TipoMovimentacaoAtualizacaoValidation")
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
    public function atualizar(Int $id, TipoMovimentacaoAtualizacaoValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = TipoMovimentacaoAtualizacaoDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
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

    /**
     * @OA\get(
     *     path="/material/tipo-movimentacao",
     *     summary="Buscar todas os tipos de movimentacao paginados",
     *     tags={"Tipo Movimentacacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="buscar",
     *          in="query",
     *          description="Texto para busca por nome",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ordenacao",
     *          in="query",
     *          description="Campo de ordenação",
     *          required=false,
     *          @OA\Schema(type="string", enum={"nome", "tipo"})
     *      ),
     *      @OA\Parameter(
     *          name="tipoOrdenacao",
     *          in="query",
     *          description="Tipo de ordenação ASC ou DESC",
     *          required=false,
     *          @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *      ),
     *      @OA\Parameter(
     *          name="pagina",
     *          in="query",
     *          description="Número da página (mínimo 1)",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *      ),
     *      @OA\Parameter(
     *          name="itensPorPagina",
     *          in="query",
     *          description="Quantidade de itens por página (mínimo 1)",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *      ),
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
    public function buscarTodosPaginado(TipoMovimentacaoBuscarTodosParamsValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = TipoMovimentacaoBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, TipoMovimentacaoResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
