<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\BaseController;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\BuscarRemuneracaoPorFuncionarioValidation;
use App\Validations\Funcionario\CriarRemuneracaoFuncionarioValidation;
use App\Validations\Funcionario\CriarRemuneracaoTipoFuncionarioValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioRemuneracaoController extends BaseController
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
     *     path="/funcionario/{id_funcionario}/remuneracao",
     *     summary="Buscar as remuneracoes do funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_funcionario",
     *          in="path",
     *          description="Id do funcionario",
     *          required=true,
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
    public function buscarRemuneracaoPorFuncionario(Request $request, int $id_funcionario) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    "id_funcionario" => $id_funcionario,
                    ...$request->query()
                ],
                BuscarRemuneracaoPorFuncionarioValidation::rules(),
                BuscarRemuneracaoPorFuncionarioValidation::messages()
            );

            $remuneracoes = $this->funcionarioService->buscarRemuneracaoPorFuncionario($id_funcionario, $request->query());

            return $this->sucessoResponse($remuneracoes);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/remuneracao",
     *     summary="Cadastra uma nova remuneracao",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"funcionario_id_funcionario", "funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo", "valor"},
     *          @OA\Property(property="funcionario_id_funcionario", type="integer", description="id do funcionario"),
     *          @OA\Property(property="funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo", type="integer", description="id do tipo de remuneracao"),
     *          @OA\Property(property="valor", type="float", description="valor da remuneracao"),
     *          @OA\Property(property="inicio", type="string", format="date", description="inicio da remuneracao"),
     *          @OA\Property(property="fim", type="string", format="date", description="fim da remuneracao")
     *      )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->all(),
                CriarRemuneracaoFuncionarioValidation::rules(),
                CriarRemuneracaoFuncionarioValidation::messages()
            );

            $remuneracao = $this->funcionarioService->cadastrarRemuneracao($request->all());

            return $this->sucessoResponse($remuneracao);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/funcionario/remuneracao/{id_remuneracao}",
     *     summary="Deletar uma remuneracao",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *      @OA\Parameter(
     *         name="id_remuneracao",
     *         in="path",
     *         description="ID da remuneracao",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function destroy(int $id_remuneracao) : JsonResponse
    {
        try {
            $deletado = $this->funcionarioService->deletarRemuneracao($id_remuneracao);

            return $this->sucessoResponse($deletado);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/remuneracao/tipo",
     *     summary="Busca os tipos de remuneração",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function pegarRemuneracaoTipo() : JsonResponse
    {
        try {
            $tipos = $this->funcionarioService->pegarRemuneracaoTipo();

            return $this->sucessoResponse($tipos);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

    /**
     * @OA\Post(
     *     path="/funcionario/remuneracao/tipo",
     *     summary="Cadastra um novo tipo de remuneracao",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *          required={"descricao"},
     *          @OA\Property(property="descricao", type="string", maxLength=255, description="Descricao do tipo")
     *      )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarRemuneracaoTipo(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->all(),
                CriarRemuneracaoTipoFuncionarioValidation::rules(),
                CriarRemuneracaoTipoFuncionarioValidation::messages()
            );

            $tipo = $this->funcionarioService->cadastrarRemuneracaoTipo($request->descricao);

            return $this->sucessoResponse($tipo);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
