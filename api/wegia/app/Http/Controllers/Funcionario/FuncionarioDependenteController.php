<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\BaseController;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\CriarDependenteParentescoValidation;
use App\Validations\Funcionario\CriarFuncionarioDepententeValidation;
use App\Validations\Funcionario\IdFuncionarioValidation;
use App\Validations\PaginacaoValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioDependenteController extends BaseController
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
     *     path="/funcionario/{id_funcionario}/dependente",
     *     summary="Buscar os dependentes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_funcionario",
     *          in="path",
     *          description="Id do funcionario",
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
    public function index(Request $request, int $id_funcionario) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    'id_funcionario' => $id_funcionario,
                    ...$request->all()
                ],
                [
                    ...IdFuncionarioValidation::rules(),
                    ...PaginacaoValidation::rules()
                ],
                [
                    ...IdFuncionarioValidation::messages(),
                    ...PaginacaoValidation::messages()
                ]
            );

            $dependentes = $this->funcionarioService->buscarDependentesPorFuncionario($request->all(), $id_funcionario);

            return $this->sucessoResponse($dependentes);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/dependente",
     *     summary="Cadastra um novo dependente para um funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_funcionario", "cpf", "nome", "sobrenome", "sexo", "telefone", "data_nascimento", "id_parentesco"},
     *             @OA\Property(property="id_funcionario", type="integer", description="ID do funcionário"),
     *             @OA\Property(property="id_pessoa", type="integer", description="id da pessoa que é dependente"),
     *             @OA\Property(property="id_parentesco", type="integer", description="ID do parentesco do dependente")
     *         )
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
                CriarFuncionarioDepententeValidation::rules($request->id_funcionario),
                CriarFuncionarioDepententeValidation::messages()
            );

            $dependente = $this->funcionarioService->cadastrarDependente($request->all());

            return $this->sucessoResponse($dependente, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/funcionario/dependente/{id_dependente}",
     *     summary="Deletar um dependente",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *      @OA\Parameter(
     *         name="id_dependente",
     *         in="path",
     *         description="ID do dependente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function destroy(int $id_dependente) : JsonResponse
    {
        try {
            $dependente = $this->funcionarioService->excluirDependente($id_dependente);

            return $this->sucessoResponse($dependente);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/dependente/tipo",
     *     summary="Buscar os tipos de dependentes possiveis",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarDependenteParentesco() : JsonResponse
    {
        try {
            $tipo = $this->funcionarioService->buscarDependenteParentesco();

            return $this->sucessoResponse($tipo);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/dependente/tipo",
     *     summary="Cadastra um tipo de parentesco do dependente",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}}, 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"descricao"},
     *             @OA\Property(property="descricao", type="string", description="Tipo de parentesco"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarDependenteParentesco(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->only('descricao'),
                CriarDependenteParentescoValidation::rules(),
                CriarDependenteParentescoValidation::messages()
            );

            $tipo = $this->funcionarioService->cadastrarDependenteParentesco($request->only('descricao'));

            return $this->sucessoResponse($tipo);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }
}
