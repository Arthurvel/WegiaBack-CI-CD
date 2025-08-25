<?php

namespace App\Http\Controllers\Funcionario;

use app\DTOs\Funcionario\FuncionarioAtualizarDTO;
use app\DTOs\Funcionario\FuncionarioBuscarDTO;
use app\DTOs\Funcionario\FuncionarioBuscarTodosDTO;
use app\DTOs\Funcionario\FuncionarioCadastrarDTO;
use App\DTOs\Pessoa\PessoaCadastrarDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Funcionario\FuncionarioResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use App\Services\FuncionarioService;
use app\Validations\Funcionario\FuncionarioAtualizarValidation;
use app\Validations\Funcionario\FuncionarioBuscarValidation;
use app\Validations\Funcionario\FuncionarioCadastrarValidation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioController extends BaseController
{

    protected FuncionarioService $funcionarioService;

    public function __construct(
        FuncionarioService $funcionarioService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-funcionario'])->only(['buscarTodos', 'index', 'findById']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-funcionario'])->only(['update']);
        $this->middleware(['auth:sanctum', 'ability:criar-funcionario'])->only(['create']);
        $this->middleware('auth:sanctum')->except([]);

        $this->funcionarioService = $funcionarioService;
    }

    /**
     * @OA\Get(
     *     path="/funcionario/todos",
     *     summary="Buscar por todos os funcionarios",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="permissao",
     *          in="query",
     *          description="Nome da permissao",
     *          required=false,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function buscarTodos(Request $request) : JsonResponse
    {
        try {
            $dto = FuncionarioBuscarTodosDTO::fromArray([
                'permissao' => $request->query('permissao')
            ]);

            $funcionarios = $this->funcionarioService->buscarTodosFiltrados($dto);

            return $this->sucessoResponse(FuncionarioResource::collection($funcionarios));
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario",
     *     summary="Buscar os funcionarios",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_situacao",
     *          in="query",
     *          description="Id da situacao do funcionario",
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
    public function index(FuncionarioBuscarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioBuscarDTO::fromArray($validated);

            $funcionarios = $this->funcionarioService->pegarFuncionarios($dto);

            return $this->sucessoResponse(new PaginacaoResource($funcionarios, FuncionarioResource::class));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}",
     *     summary="Buscar funcionario pelo id",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_funcionario",
     *          in="path",
     *          description="Id do funcionario",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function findById(int $id_funcionario) : JsonResponse
    {
        try {
            $with = ['pessoa'];
            $funcionario = $this->funcionarioService->buscarPorId($id_funcionario, $with);

            return $this->sucessoResponse(new FuncionarioResource($funcionario));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario",
     *     summary="Cadastrar uma novo funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FuncionarioCadastrarValidation")
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(FuncionarioCadastrarValidation $request) : JsonResponse
    {
        try {
           $validated = $request->validated();

           $pessoaDTO = PessoaCadastrarDTO::fromArray($validated);
           $funcionarioDTO = FuncionarioCadastrarDTO::fromArray($validated);

            $resultado = $this->funcionarioService->cadastrarFuncionario($funcionarioDTO, $pessoaDTO);

            return $this->sucessoResponse($resultado, 201);

        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/funcionario/{id_funcionario}",
     *     summary="Atualizar um funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do Funcionario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FuncionarioAtualizarValidation")
     *     ),
     *     @OA\Response(response="200", description="Funcionario atualizado realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function update(FuncionarioAtualizarValidation $request, int $id_funcionario) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioAtualizarDTO::fromArray($validated);

            $resultado = $this->funcionarioService->atualizar($id_funcionario, $dto);

            return $this->sucessoResponse($resultado);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
