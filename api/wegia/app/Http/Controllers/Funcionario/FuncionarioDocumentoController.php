<?php

namespace App\Http\Controllers\Funcionario;

use app\DTOs\Funcionario\Documento\FuncionarioDocumentoBuscarDTO;
use app\DTOs\Funcionario\Documento\FuncionarioDocumentoCadastrarDTO;
use app\DTOs\Funcionario\Documento\FuncionarioDocumentoTipoCadastrarDTO;
use App\DTOs\Funcionario\FuncionarioDocumentoDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Funcionario\FuncionarioDocumentoResource;
use app\Http\Resources\Funcionario\FuncionarioDocumentoTipoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Funcionario\FuncionarioDocumentoService;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\CriarDocumentoFuncionarioValidation;
use App\Validations\Funcionario\CriarDocumentoTipoFuncionarioValidation;
use app\Validations\Funcionario\Documento\FuncionarioDocumentoTipoCadastrarValidation;
use app\Validations\Funcionario\Documento\FuncionarioDocumentoValidation;
use App\Validations\PaginacaoValidation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioDocumentoController extends BaseController
{

    protected FuncionarioDocumentoService $service;

    public function __construct(
        FuncionarioDocumentoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:cadastrar-arquivo-do-funcionario'])->only(['adicionarDocumento', 'cadastrarDocumentoTipo']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-arquivo-do-funcionario'])->only(['pegarDocumentosDeUmFuncionario', 'buscarDocumentoTipo']);
        $this->middleware(['auth:sanctum', 'ability:deletar-arquivo-do-funcionario'])->only(['deletarDocumento', 'buscarDocumentoTipo']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/funcionario/{id_funcionario}/documento",
     *     summary="Adicionar um documento para um funcionário",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do funcionário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do documento a ser enviado",
     *         @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/FuncionarioDocumentoValidation")
     *           )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function adicionarDocumento(FuncionarioDocumentoValidation $request, int $id_funcionario) : JsonResponse
    {
        try {

            $validated = $request->validated();
            $foto = $request->file('arquivo') ?? null;

            $dto = FuncionarioDocumentoCadastrarDTO::fromArray([
                ...$validated,
                'arquivo' => $foto,
                'id_funcionario' => $id_funcionario
            ]);

            $resultado = $this->service->cadastrarDocumento($dto);

            return $this->sucessoResponse($resultado, 201);

        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}/documento",
     *     summary="Pegar os documentos do funcionário",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do funcionário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Tipo do arquivo ou data para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (tipo do arquivo, data)",
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
    public function pegarDocumentosDeUmFuncionario(PaginacaoValidation $request, int $id_funcionario) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioDocumentoBuscarDTO::fromArray([
                ...$validated,
                'id_funcionario' => $id_funcionario
            ]);

            $documentos = $this->service->pegarDocumentos($dto);

            return  $this->sucessoResponse(new PaginacaoResource($documentos, FuncionarioDocumentoResource::class));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/funcionario/documento/{id_documento}",
     *     summary="Deletar o documentos do funcionário",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_documento",
     *         in="path",
     *         description="ID do documento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function deletarDocumento(int $id_documento) : JsonResponse
    {
        try {
           $this->service->deletar($id_documento);

            return  $this->sucessoResponse(true, 204);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/documento/tipo",
     *     summary="Pegar os tipos de documentos do funcionário",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarDocumentoTipo() : JsonResponse
    {
        try {
            $tipo = $this->service->buscarDocumentoTipo();

            return  $this->sucessoResponse(FuncionarioDocumentoTipoResource::collection($tipo));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/documento/tipo",
     *     summary="Adicionar um novo tipo de documento",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do documento a ser enviado",
     *         @OA\JsonContent(ref="#/components/schemas/FuncionarioDocumentoTipoCadastrarValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarDocumentoTipo(FuncionarioDocumentoTipoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioDocumentoTipoCadastrarDTO::fromArray($validated);

            $tipo = $this->service->cadastrarDocumentoTipo($dto);

            return  $this->sucessoResponse($tipo, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
