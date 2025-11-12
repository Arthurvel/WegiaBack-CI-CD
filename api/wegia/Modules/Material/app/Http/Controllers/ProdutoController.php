<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Material\app\DTO\ProdutoAtualizarDTO;
use Modules\Material\app\DTO\ProdutoBuscarTodosParamsDTO;
use Modules\Material\app\DTO\ProdutoCadastrarDTO;
use Modules\Material\app\Http\Resources\ProdutoResource;
use Modules\Material\app\Services\ProdutoService;
use Modules\Material\app\Validations\ProdutoAtualizarValidation;
use Modules\Material\app\Validations\ProdutoBuscarTodosParamsValidation;
use Modules\Material\app\Validations\ProdutoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Produto",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class ProdutoController extends BaseController
{

    public ProdutoService $service;

    public function __construct(
        ProdutoService $service
    )
    {

        $this->middleware(['auth:sanctum', 'ability:visualizar-produto-material'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum', 'ability:criar-produto-material'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-produto-material'])->only(['atualizar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-relatorio-material,criar-entrada-de-material,criar-saida-de-material'])->only(['buscarTodosParaFiltro']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/produto",
     *     summary="Cadastra um produto de transacao",
     *     tags={"Produto"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProdutoCadastrarValidation")
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
    public function cadastrar(ProdutoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ProdutoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/produto/",
     *     summary="Buscar todas os produtos paginados",
     *     tags={"Produto"},
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
    public function buscarTodos(ProdutoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ProdutoBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, ProdutoResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/produto/filtros",
     *     summary="Buscar todas os produtos para filtros",
     *     tags={"Produto"},
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
            $buscar = $this->service->buscarTodos();

            return $this->sucessoResponse(ProdutoResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/material/produto/{id}",
     *     summary="Atualiza um produto",
     *     tags={"Produto"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do produto",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProdutoAtualizarValidation")
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
    public function atualizar(int $id, ProdutoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ProdutoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
