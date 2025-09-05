<?php

namespace App\Http\Controllers\Atendido;

use app\DTOs\Atendido\AtendidoBuscarDTO;
use app\DTOs\Atendido\AtendidoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Atendido\AtendidoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Atendido\AtendidoService;
use App\Validations\Atendido\AtendidoBuscarPorIdValidation;
use App\Validations\Atendido\AtendidoBuscarValidation;
use App\Validations\Atendido\AtendidoCadastrarValidation;
use Exception;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Atendido",
 *     description="Operações relacionadas dos atendidos"
 * )
 */
class AtendidoController extends BaseController
{

    protected AtendidoService $atendidoService;

    public function __construct(
        AtendidoService $atendidoService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-atendido'])->only(['create']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-atendido'])->only(['atendidoPorId', 'index']);
        $this->middleware('auth:sanctum')->except([]);

        $this->atendidoService = $atendidoService;
    }


    /**
     * @OA\Get(
     *     path="/atendido",
     *     summary="Buscar os Atendidos",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_status",
     *          in="query",
     *          description="Id do status do atendido",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Nome ou CPF do atendido para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (nome e cpf)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tipoOrdenacao",
     *         in="query",
     *         description="Tipo de ordenação",
     *         required=false,
     *         @OA\Schema(type="string", default="ASC")
     *     ),
     *     @OA\Parameter(
     *         name="with",
     *         in="query",
     *         description="Separados por virgula",
     *         required=false,
     *         @OA\Schema(type="string", default="")
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Quantidade de itens por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="pagina",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index(AtendidoBuscarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoBuscarDTO::fromArray($validated);

            $atendidos = $this->atendidoService->buscarAtendimentos($dto);

            return  $this->sucessoResponse(new PaginacaoResource($atendidos, AtendidoResource::class));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/atendido/{id}",
     *     summary="Buscar Atendido por ID",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id do  atendido",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="with",
     *         in="query",
     *         description="Separados por virgula",
     *         required=false,
     *         @OA\Schema(type="string", default="")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function atendidoPorId($id, AtendidoBuscarPorIdValidation $request)
    {
        try {
            $validated = $request->validated();

            $with = isset($validated['with']) ? [$validated['with']] : [];

            $atendido = $this->atendidoService->buscarPorId($id, $with);

            return  $this->sucessoResponse(new AtendidoResource($atendido));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/atendido",
     *     summary="Cadastrar um novo Atendido",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AtendidoCadastrarValidation")
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(AtendidoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoCadastrarDTO::fromArray($validated);

            $this->atendidoService->criar($dto);

            return  $this->sucessoResponse(true, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
