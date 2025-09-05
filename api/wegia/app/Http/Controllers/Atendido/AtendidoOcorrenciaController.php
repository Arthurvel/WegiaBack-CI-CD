<?php

namespace App\Http\Controllers\Atendido;

use app\DTOs\Atendido\AtendidoOcorrenciaBuscarDTO;
use app\DTOs\Atendido\AtendidoOcorrenciaComFotoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Atendido\AtendidoOcorrenciaResource;
use app\Http\Resources\Atendido\AtendidoOcorrenciaTipoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Atendido\AtendidoOcorrenciaService;
use app\Services\Atendido\AtendidoService;
use App\Validations\Atendido\Ocorrencia\AtendidoOcorrenciaBuscarValidation;
use App\Validations\Atendido\Ocorrencia\AtendidoOcorrenciaCadastrarValidation;
use Exception;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Atendido",
 *     description="Operações relacionadas dos atendidos"
 * )
 */
class AtendidoOcorrenciaController extends BaseController
{

    protected AtendidoOcorrenciaService $service;

    public function __construct(
        AtendidoOcorrenciaService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-ocorrencia-dos-atendidos'])->only(['index']);
        $this->middleware(['auth:sanctum', 'ability:criar-ocorrencia-dos-atendidos'])->only(['criarOcorrencia', 'buscarOrrenciaTipos']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
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
    public function index(int $id, AtendidoOcorrenciaBuscarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoOcorrenciaBuscarDTO::fromArray([
                'id_atendido' => $id,
                ...$validated
            ]);

            $ocorrencias = $this->service->buscarOcorrencias($dto);

            return  $this->sucessoResponse(new PaginacaoResource($ocorrencias, AtendidoOcorrenciaResource::class));
        } catch (Exception $e) {
            return $this->errorResponse($e);
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
     *          required=true,
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/AtendidoOcorrenciaCadastrarValidation")
     *           )
     *      ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function criarOcorrencia(int $id, AtendidoOcorrenciaCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();
            $arquivo = $request->file('arquivo') ?? null;

            $dto = AtendidoOcorrenciaComFotoCadastrarDTO::fromArray([
                ...$validated,
                'arquivo' => $arquivo,
                'atendido_idatendido' => $id
            ]);

            $ocorrencia = $this->service->cadastrarOcorrencia($dto);

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
            $tipos = $this->service->buscarOcorrenciaTipos();

            return  $this->sucessoResponse(AtendidoOcorrenciaTipoResource::collection($tipos));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
