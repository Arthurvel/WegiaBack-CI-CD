<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\BaseController;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\CriarDocumentoFuncionarioValidation;
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

    protected $funcionarioService;

    public function __construct(
        FuncionarioService $funcionarioService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->funcionarioService = $funcionarioService;
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
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="arquivo", type="string", format="binary", description="Arquivo a ser enviado (PDF, JPG, PNG)"),
     *                 @OA\Property(property="id_docfuncional", type="integer", nullable=true, description="ID do documento funcional")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function adicionarDocumento(Request $request, int $id_funcionario) : JsonResponse
    {
        try {
            $request->merge(['id_funcionario' => $id_funcionario]);

            $this->validarRequest(
                $request->only(['arquivo', 'id_funcionario', 'id_docfuncional']),
                CriarDocumentoFuncionarioValidation::rules(),
                CriarDocumentoFuncionarioValidation::messages()
            );

            $resultado = $this->funcionarioService->cadastrarDocumento(
                $request->file('arquivo'),
                $id_funcionario,
                $request->id_docfuncional
            );

            return $this->sucessoResponse($resultado);
            
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
    public function pegarDocumentosDeUmFuncionario(Request $request, int $id_funcionario) : JsonResponse
    {
        try {
            $documentos = $this->funcionarioService->pegarDocumentos($request->query(), $id_funcionario);

            return  $this->sucessoResponse($documentos);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
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
            $documentoDeletado = $this->funcionarioService->deletarDocumento($id_documento);

            return  $this->sucessoResponse($documentoDeletado);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

}
