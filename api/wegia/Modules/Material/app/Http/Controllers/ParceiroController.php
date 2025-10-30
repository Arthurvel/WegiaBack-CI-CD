<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\ParceiroAtualizarDTO;
use Modules\Material\app\DTO\ParceiroBuscarTodosParamsDTO;
use Modules\Material\app\DTO\ParceiroCadastrarDTO;
use Modules\Material\app\Http\Resources\ParceiroResource;
use Modules\Material\app\Services\ParceiroService;
use Modules\Material\app\Validations\ParceiroAtualizarValidation;
use Modules\Material\app\Validations\ParceiroBuscarTodosParamsValidation;
use Modules\Material\app\Validations\ParceiroCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Parceiro",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class ParceiroController extends BaseController
{

    public ParceiroService $service;

    public function __construct(
        ParceiroService $service
    )
    {
//        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
//        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/parceiro",
     *     summary="Cadastra um parceiro de transacao",
     *     tags={"Parceiro"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ParceiroCadastrarValidation")
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
    public function cadastrar(ParceiroCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ParceiroCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/material/parceiro/{id}",
     *     summary="Atualiza um parceiro",
     *     tags={"Parceiro"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do parceiro",
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
    public function atualizar(Int $id, ParceiroAtualizarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = ParceiroAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/parceiro/filtros",
     *     summary="Buscar todas os parceiros para filtros",
     *     tags={"Parceiro"},
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

            return $this->sucessoResponse(ParceiroResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/parceiro",
     *     summary="Buscar todas os parceiros paginados",
     *     tags={"Parceiro"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="buscar",
     *          in="query",
     *          description="Texto para busca por nome, cpf e cnpj",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ordenacao",
     *          in="query",
     *          description="Campo de ordenação",
     *          required=false,
     *          @OA\Schema(type="string", enum={"nome", "cpf", "cnpj", "telefone"})
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
    public function buscarTodosPaginado(ParceiroBuscarTodosParamsValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = ParceiroBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, ParceiroResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
