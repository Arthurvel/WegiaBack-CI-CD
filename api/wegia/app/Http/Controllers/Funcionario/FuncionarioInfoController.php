<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\BaseController;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\BuscarFuncionarioInfoValidation;
use App\Validations\Funcionario\CriarListaInfoFuncionarioValidation;
use App\Validations\Funcionario\CriarOutraInfoFuncionarioValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioInfoController extends BaseController
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
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}/outra-info",
     *     summary="Busca todas as informações de um funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *      @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do Funcionario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Dado ou Descricao do item e da lista para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (descricao, dados)",
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
    public function buscarInfosPorIdFuncionario(Request $request, int $id_funcionario) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    ...$request->query(),
                    "id_funcionario" => $id_funcionario
                ],
                BuscarFuncionarioInfoValidation::rules(),
                BuscarFuncionarioInfoValidation::messages()
            );

            $info = $this->funcionarioService->buscarInfosPorIdFuncionario($id_funcionario, $request->query());

            return $this->sucessoResponse($info);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/{id_funcionario}/outra-info/{id_funcionario_lista_info}",
     *     summary="Cadastra um novo item na lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *      @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do Funcionario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="id_funcionario_lista_info",
     *         in="path",
     *         description="ID do item na lista de informacoes",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"dado"},
     *          @OA\Property(property="dado", type="string", maxLength=255, description="Dados a serem cadastrados")
     *      )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function create(Request $request, int $id_funcionario, int $id_funcionario_lista_info) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    ...$request->all(),
                    "id_funcionario" => $id_funcionario,
                    "id_funcionario_lista_info" => $id_funcionario_lista_info
                ],
                CriarOutraInfoFuncionarioValidation::rules(),
                CriarOutraInfoFuncionarioValidation::messages()
            );

            $info = $this->funcionarioService->cadastrarInfo($request->dado, $id_funcionario, $id_funcionario_lista_info);

            return $this->sucessoResponse($info);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/funcionario/outra-info/{id_funcionario_outrasinfo}",
     *     summary="Deletar um item na lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *      @OA\Parameter(
     *         name="id_funcionario_outrasinfo",
     *         in="path",
     *         description="ID da outra informacao",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function destroy(int $id_funcionario_outrasinfo) : JsonResponse
    {
        try {
            $info = $this->funcionarioService->deletarInfo($id_funcionario_outrasinfo);

            return $this->sucessoResponse($info);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/lista-info",
     *     summary="Busca todos os itens da lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function pegarListaInfo() : JsonResponse
    {
        try {
            $listaInfo = $this->funcionarioService->pegarListaInfo();

            return $this->sucessoResponse($listaInfo);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/lista-info",
     *     summary="Cadastra um novo item na lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"descricao"},
     *          @OA\Property(property="descricao", type="string", maxLength=255, description="Descricao único")
     *      )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarListaInfo(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->all(),
                CriarListaInfoFuncionarioValidation::rules(),
                CriarListaInfoFuncionarioValidation::messages()
            );

            $listaCriada = $this->funcionarioService->cadastrarListaInfo($request->descricao);

            return $this->sucessoResponse($listaCriada);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

}
