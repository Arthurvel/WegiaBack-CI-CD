<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Material\app\DTO\AlmoxarifadoAtualizarDTO;
use Modules\Material\app\DTO\AlmoxarifadoBuscarTodosParamsDTO;
use Modules\Material\app\DTO\AlmoxarifadoCadastrarDTO;
use Modules\Material\app\Http\Resources\AlmoxarifadoResource;
use Modules\Material\app\Services\AlmoxarifadoService;
use Modules\Material\app\Validations\AlmoxarifadoAtualizarValidation;
use Modules\Material\app\Validations\AlmoxarifadoCadastrarValidation;
use Modules\Material\app\Validations\AlmoxarifadoBuscarTodosParamsValidation;

/**
 * @OA\Tag(
 *     name="Almoxarifado",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class AlmoxarifadoController extends BaseController
{

    public AlmoxarifadoService $service;

    public function __construct(
        AlmoxarifadoService $service
    )
    {

        $this->middleware(['auth:sanctum', 'ability:criar-almoxarifado-do-material'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-almoxarifado-do-material'])->only(['buscarTodosPaginados']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-almoxarifado-do-material'])->only(['atualizar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-relatorio-material,criar-entrada-de-material,criar-saida-de-material'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/almoxarifado",
     *     summary="Cadastra um almoxarifado",
     *     tags={"Almoxarifado"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AlmoxarifadoCadastrarValidation")
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
    public function cadastrar(AlmoxarifadoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = AlmoxarifadoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/material/almoxarifado/{id}",
     *     summary="Atualizar um almoxarifado",
     *     tags={"Almoxarifado"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do almoxarifado",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AlmoxarifadoAtualizarValidation")
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
    public function atualizar(int $id, AlmoxarifadoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = AlmoxarifadoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/material/almoxarifado",
     *     summary="Buscar todos os almoxarifados paginados",
     *     tags={"Almoxarifado"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *           name="buscar",
     *           in="query",
     *           description="Texto para busca por nome",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *           name="ordenacao",
     *           in="query",
     *           description="Campo de ordenação",
     *           required=false,
     *           @OA\Schema(type="string", enum={"descricao_almoxarifado"})
     *       ),
     *       @OA\Parameter(
     *           name="tipoOrdenacao",
     *           in="query",
     *           description="Tipo de ordenação ASC ou DESC",
     *           required=false,
     *           @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *       ),
     *       @OA\Parameter(
     *           name="pagina",
     *           in="query",
     *           description="Número da página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
     *       @OA\Parameter(
     *           name="itensPorPagina",
     *           in="query",
     *           description="Quantidade de itens por página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
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
    public function buscarTodosPaginados(AlmoxarifadoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = AlmoxarifadoBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginados($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, AlmoxarifadoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/almoxarifado/filtros",
     *     summary="Buscar todas os almoxarifados para filtros",
     *     tags={"Almoxarifado"},
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
    public function buscarTodos()
    {
        try {
            $buscar = $this->service->buscarTodos();

            return $this->sucessoResponse(AlmoxarifadoResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
