<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\CategoriaAtualizarDTO;
use Modules\Material\app\DTO\CategoriaBuscarTodosParamsDTO;
use Modules\Material\app\DTO\CategoriaCadastrarDTO;
use Modules\Material\app\Http\Resources\CategoriaResource;
use Modules\Material\app\Services\CategoriaService;
use Modules\Material\app\Validations\CategoriaAtualizarValidation;
use Modules\Material\app\Validations\CategoriaBuscarTodosParamsValidation;
use Modules\Material\app\Validations\CategoriaCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Almoxarifado",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class CategoriaController extends BaseController
{

    public CategoriaService $service;

    public function __construct(
        CategoriaService $service
    )
    {
//        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
//        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/categoria",
     *     summary="Cadastra uma categoria",
     *     tags={"Categoria"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoriaCadastrarValidation")
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
    public function cadastrar(CategoriaCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = CategoriaCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/material/categoria/{id}",
     *     summary="Atualizar uma categoria",
     *     tags={"Categoria"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da categoria",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoriaAtualizarValidation")
     *      ),
     *     @OA\Response(
     *         response=204,
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
    public function atualizar(int $id, CategoriaAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = CategoriaAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/categoria/filtros",
     *     summary="Buscar todas as categorias para filtros",
     *     tags={"Categoria"},
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

            return $this->sucessoResponse(CategoriaResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/categoria",
     *     summary="Buscar todas as categorias paginados",
     *     tags={"Categoria"},
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
     *          @OA\Schema(type="string", enum={"descricao", "codigo", "descricao_categoria", "descricao_unidade"})
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
    public function buscarTodosPaginado(CategoriaBuscarTodosParamsValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = CategoriaBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, CategoriaResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
