<?php

namespace App\Http\Controllers\Funcionario;

use app\DTOs\Funcionario\Dependente\FuncionarioDependenteBuscarDTO;
use app\DTOs\Funcionario\Dependente\FuncionarioDependenteCadastrarDTO;
use app\DTOs\Funcionario\Dependente\FuncionarioDependenteParentescoCadastrarDTO;
use App\DTOs\PaginacaoDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Funcionario\FuncionarioDependenteResource;
use app\Http\Resources\Funcionario\FuncionarioParentescoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Funcionario\FuncionarioDependenteService;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\CriarDependenteParentescoValidation;
use App\Validations\Funcionario\CriarFuncionarioDepententeValidation;
use app\Validations\Funcionario\Dependente\FuncionarioDependenteBuscarValidation;
use app\Validations\Funcionario\Dependente\FuncionarioDependenteCadastrarValidation;
use app\Validations\Funcionario\Dependente\FuncionarioDependenteParentescoCadastrarValidation;
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

    protected FuncionarioDependenteService $service;

    public function __construct(
        FuncionarioDependenteService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-dependente'])->only(['index', 'buscarDependenteParentesco']);
        $this->middleware(['auth:sanctum', 'ability:criar-dependente'])->only(['create', 'cadastrarDependenteParentesco']);
        $this->middleware(['auth:sanctum', 'ability:deletar-dependente'])->only(['destroy']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
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
    public function index(PaginacaoValidation $request, int $id_funcionario) : JsonResponse
    {
        try {

            $validated = $request->validated();

            $dto = FuncionarioDependenteBuscarDTO::fromArray($validated);
            $dto->id_funcionario = $id_funcionario;

            $dependentes = $this->service->buscarDependentesPorFuncionario($dto);

            return $this->sucessoResponse(new PaginacaoResource($dependentes, FuncionarioDependenteResource::class));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/dependente",
     *     summary="Cadastra um novo dependente para um funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/FuncionarioDependenteCadastrarValidation")
     *      ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function create(FuncionarioDependenteCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioDependenteCadastrarDTO::fromArray($validated);

            $dependente = $this->service->criar($dto);

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
            $this->service->deletar($id_dependente);

            return $this->sucessoResponse(true, 204);
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
            $tipo = $this->service->buscarDependenteParentesco();

            return $this->sucessoResponse(FuncionarioParentescoResource::collection($tipo));
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
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/FuncionarioDependenteParentescoCadastrarValidation")
     *      ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarDependenteParentesco(FuncionarioDependenteParentescoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioDependenteParentescoCadastrarDTO::fromArray($validated);

            $tipo = $this->service->cadastrarDependenteParentesco($dto);

            return $this->sucessoResponse($tipo, 201);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }
}
