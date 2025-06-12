<?php

namespace App\Http\Controllers\Atendido;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\AtendidoService;
use App\Validations\Atendido\BuscarAtendidoIdValidation;
use App\Validations\Atendido\BuscarAtendidoValidation;
use App\Validations\Atendido\CriarAtendido;
use Exception;

/**
 * @OA\Tag(
 *     name="Atendido",
 *     description="Operações relacionadas dos atendidos"
 * )
 */
class AtendidoController extends BaseController
{

    protected $atendidoService;

    public function __construct(
        AtendidoService $atendidoService
    )
    {
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
    public function index(Request $request)
    {
        try {
            $this->validarRequest(
                $request->query(),
                BuscarAtendidoValidation::rules(),
                BuscarAtendidoValidation::messages()
            );

            $atendidos = $this->atendidoService->buscarAtendimentos($request->query());

            return  $this->sucessoResponse($atendidos);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
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
    public function atendidoPorId($id, Request $request)
    {
        try {
            $this->validarRequest(
                ["id" => $id, ...$request->query()],
                BuscarAtendidoIdValidation::rules(),
                BuscarAtendidoValidation::messages()
            );

            $atendido = $this->atendidoService->buscarAtendidoPorId($id, $request->query('with'));

            return  $this->sucessoResponse($atendido->toArray());
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
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
     *         @OA\JsonContent(
     *             required={"pessoa_id_pessoa", "atendido_tipo_idatendido_tipo", "atendido_status_idatendido_status"},
     *             @OA\Property(property="pessoa_id_pessoa", type="integer", description="id da pessoa"),
     *             @OA\Property(property="atendido_tipo_idatendido_tipo", type="integer", description="id do tipo do atendido"),
     *             @OA\Property(property="atendido_status_idatendido_status", type="integer", description="id do status do atendido"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request) 
    {
        try {
            $this->validarRequest(
                $request->all(),
                CriarAtendido::rules(),
                CriarAtendido::messages()
            );

            $atendidos = $this->atendidoService->cadastrarAtendido($request->all());

            return  $this->sucessoResponse($atendidos);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

}