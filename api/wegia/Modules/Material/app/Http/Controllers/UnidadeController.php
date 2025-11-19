<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\UnidadeAtualizarDTO;
use Modules\Material\app\DTO\UnidadeBuscarTodosParamsDTO;
use Modules\Material\app\DTO\UnidadeCadastrarDTO;
use Modules\Material\app\Http\Resources\UnidadeResource;
use Modules\Material\app\Services\UnidadeService;
use Modules\Material\app\Validations\UnidadeAtualizarValidation;
use Modules\Material\app\Validations\UnidadeBuscarTodosParamsValidation;
use Modules\Material\app\Validations\UnidadeCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Unidade",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class UnidadeController extends BaseController
{

    public UnidadeService $service;

    public function __construct(
        UnidadeService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-unidade-material'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-unidade-material'])->only(['buscarTodosPaginado']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-unidade-material'])->only(['atualizar']);
        $this->middleware(['auth:sanctum', 'ability:criar-produto-material,atualizar-produto-material'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/unidade",
     *     summary="Cadastra uma unidade",
     *     tags={"Unidade"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UnidadeCadastrarValidation")
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
    public function cadastrar(UnidadeCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = UnidadeCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/material/unidade/{id}",
     *     summary="Cadastra uma unidade",
     *     tags={"Unidade"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da unidade",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UnidadeAtualizarValidation")
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
    public function atualizar(Int $id, UnidadeAtualizarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = UnidadeAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/unidade/filtros",
     *     summary="Buscar todas as unidades para filtros",
     *     tags={"Unidade"},
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
    public function buscarTodos() : JsonResponse
    {
        try {
            $buscar = $this->service->buscarTodos();

            return $this->sucessoResponse(UnidadeResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/unidade",
     *     summary="Buscar todas as unidades paginados",
     *     tags={"Unidade"},
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
     *          @OA\Schema(type="string", enum={"descricao"})
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
    public function buscarTodosPaginado(UnidadeBuscarTodosParamsValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = UnidadeBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, UnidadeResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
