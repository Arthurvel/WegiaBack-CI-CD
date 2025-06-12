<?php

namespace App\Http\Controllers\Atendido;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\AtendidoService;
use App\Validations\Atendido\Ocorrencia\BuscarAtendidoOcorrenciaValidation;
use App\Validations\Atendido\Ocorrencia\CriarAtendidoOcorrenciaValidation;
use Exception;

/**
 * @OA\Tag(
 *     name="Atendido",
 *     description="Operações relacionadas dos atendidos"
 * )
 */
class AtendidoOcorrenciaController extends BaseController
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
     *     path="/atendido/{id}/ocorrencia",
     *     summary="Buscar as ocorrencias de um atendido",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id do atendido",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="id_tipo",
     *          in="query",
     *          description="Id do tipo de ocorrencia",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Nome, CPF ou Cargo do funcionário para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (nome, cpf, cargo)",
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
     *         description="Quantidade de funcionários por página",
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
    public function index(int $id, Request $request)
    {
        try {
            $this->validarRequest(
                [
                    "id_atendido" => $id,
                    ...$request->query()
                ],
                BuscarAtendidoOcorrenciaValidation::rules(),
                BuscarAtendidoOcorrenciaValidation::messages()
            );

            $ocorrencias = $this->atendidoService->buscarOcorrencias($id, $request->query());

            return  $this->sucessoResponse($ocorrencias);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        } 
    }

    /**
     * @OA\Post(
     *     path="/atendido/{id}/ocorrencia",
     *     summary="Adicionar uma nova ocorrencia",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do atendido",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do documento a ser enviado",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="arquivo", type="string", format="binary", description="Arquivo a ser enviado (PDF, JPG, PNG)"),
     *                 @OA\Property(property="atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos", type="integer", description="ID do tipo do atendido"),
     *                 @OA\Property(property="funcionario_id_funcionario", type="integer", description="ID do funcionario que esta atendendo"),
     *                 @OA\Property(property="data", type="string", format="date", description="Data da ocorrencia"),
     *                 @OA\Property(property="descricao", type="string", description="Descricao da ocorrencia"), 
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function criarOcorrencia(int $id, Request $request)
    {
        try {
            $this->validarRequest(
                [
                    "arquivo" => $request->file('arquivo'),
                    "id_atendido" => $id,
                    ...$request->all()
                ],
                CriarAtendidoOcorrenciaValidation::rules(),
                CriarAtendidoOcorrenciaValidation::messages()
            );

            $ocorrencia = $this->atendidoService->cadastrarOcorrencia($id, $request->all());

            return  $this->sucessoResponse($ocorrencia);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

    /**
     * @OA\Get(
     *     path="/atendido/ocorrencia/tipos",
     *     summary="Buscar Atendido por ID",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarOcorrenciaTipos()
    {
        try {
            $tipos = $this->atendidoService->buscarOcorrenciaTipos();

            return  $this->sucessoResponse($tipos);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }
}