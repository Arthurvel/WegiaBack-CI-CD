<?php

namespace Modules\Pet\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Pet\app\DTO\MedicamentoAtualizarDTO;
use Modules\Pet\app\DTO\MedicamentoBuscarTodosDTO;
use Modules\Pet\app\DTO\MedicamentoCadastrarDTO;
use Modules\Pet\app\Http\Resources\MedicamentoResource;
use Modules\Pet\app\Services\MedicamentoService;
use Modules\Pet\app\Validations\MedicamentoAtualizarValidation;
use Modules\Pet\app\Validations\MedicamentoBuscarTodosValidation;
use Modules\Pet\app\Validations\MedicamentoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Medicamento",
 *     description="Operações relacionadas ao Modulo de Pet"
 * )
 */
class MedicamentoController extends BaseController
{

    private MedicamentoService $medicamentoService;

    public function __construct(
        MedicamentoService $medicamentoService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-medicamento'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-medicamento'])->only(['atualizar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-medicamento'])->only(['buscarTodosParaFiltro', 'index', 'buscarPorId']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->medicamentoService = $medicamentoService;
    }

    /**
     * @OA\Get(
     *     path="/medicamento",
     *     summary="Busca todos os medicamentos paginado",
     *     tags={"Medicamento"},
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
     *          description="Campo de ordenação (nome_medicamento)",
     *          required=false,
     *          @OA\Schema(type="string", enum={"nome_medicamento"})
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
     *         description="Medicamento cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function index(MedicamentoBuscarTodosValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = MedicamentoBuscarTodosDTO::fromArray($validated);

            $medicamentos = $this->medicamentoService->buscarTodosPaginado($dto);

            return $this->sucessoResponse(new PaginacaoResource($medicamentos, MedicamentoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/medicamento/{id}",
     *     summary="Buscar por um medicamento",
     *     tags={"Medicamento"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID do medicamento",
     *           required=true,
     *           @OA\Schema(type="integer")
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
    public function buscarPorId(int $id)
    {
        try {
            $medicamento = $this->medicamentoService->buscarPorId($id);

            return $this->sucessoResponse(new MedicamentoResource($medicamento));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\Get(
     *     path="/medicamento/filtro",
     *     summary="Busca todos os medicamentos para usar em filtros",
     *     tags={"Medicamento"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Medicamento cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarTodosParaFiltro() : JsonResponse
    {
        try {
            $medicamentos = $this->medicamentoService->buscarTodos();

            return $this->sucessoResponse($medicamentos);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/medicamento",
     *     summary="Cadastra um medicamento",
     *     tags={"Medicamento"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MedicamentoCadastrarValidation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Medicamento cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(MedicamentoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = MedicamentoCadastrarDTO::fromArray($validated);

            $criado = $this->medicamentoService->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/medicamento/{id}",
     *     summary="Atualizar um medicamento",
     *     tags={"Medicamento"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID do medicamento",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/MedicamentoAtualizarValidation")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Medicamento atualizado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function atualizar(int $id, MedicamentoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = MedicamentoAtualizarDTO::fromArray($validated);

            $this->medicamentoService->atualizar($id, $dto);

            return $this->sucessoResponse(true, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
