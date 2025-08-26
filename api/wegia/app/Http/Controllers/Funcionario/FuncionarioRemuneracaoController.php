<?php

namespace App\Http\Controllers\Funcionario;

use app\DTOs\Funcionario\Remuneracao\FuncionarioRemuneracaoBuscarDTO;
use app\DTOs\Funcionario\Remuneracao\FuncionarioRemuneracaoCadastrarDTO;
use app\DTOs\Funcionario\Remuneracao\FuncionarioRemuneracaoTipoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Funcionario\FuncionarioRemuneracaoResource;
use app\Http\Resources\Funcionario\FuncionarioRemuneracaoTipoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Funcionario\FuncionarioRemuneracaoService;
use app\Validations\Funcionario\Remuneracao\FuncionarioRemuneracaoBuscarValidation;
use app\Validations\Funcionario\Remuneracao\FuncionarioRemuneracaoCadastrarValidation;
use app\Validations\Funcionario\Remuneracao\FuncionarioRemuneracaoTipoCadastrarValidation;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioRemuneracaoController extends BaseController
{

    protected  FuncionarioRemuneracaoService $service;

    public function __construct(
        FuncionarioRemuneracaoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-remuneracao-do-funcionario'])->only(['buscarRemuneracaoPorFuncionario', 'buscarRemuneracaoTotalPorFuncionario', 'pegarRemuneracaoTipo']);
        $this->middleware(['auth:sanctum', 'ability:criar-remuneracao-do-funcionario'])->only(['create', 'cadastrarRemuneracaoTipo']);
        $this->middleware(['auth:sanctum', 'ability:deletar-remuneracao-do-funcionario'])->only(['destroy']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
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
    public function buscarRemuneracaoPorFuncionario(FuncionarioRemuneracaoBuscarValidation $request, int $id_funcionario) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioRemuneracaoBuscarDTO::fromArray([
                ...$validated,
                'id_funcionario' => $id_funcionario
            ]);

            $remuneracoes = $this->service->buscarRemuneracaoPorFuncionario($dto);

            return $this->sucessoResponse( new PaginacaoResource($remuneracoes, FuncionarioRemuneracaoResource::class) );
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
     *       @OA\JsonContent(ref="#/components/schemas/FuncionarioRemuneracaoCadastrarValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(FuncionarioRemuneracaoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioRemuneracaoCadastrarDTO::fromArray($validated);

            $remuneracao = $this->service->criar($dto);

            return $this->sucessoResponse($remuneracao, 201);
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
            $this->service->deletar($id_remuneracao);

            return $this->sucessoResponse(true, 204);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}/remuneracao/total",
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
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarRemuneracaoTotalPorFuncionario(int $id_funcionario) : JsonResponse
    {
        try {
            $total = $this->service->buscarRemuneracaoTotalPorFuncionario($id_funcionario);

            return $this->sucessoResponse($total);
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
            $tipos = $this->service->pegarRemuneracaoTipo();

            return $this->sucessoResponse(FuncionarioRemuneracaoTipoResource::collection($tipos));
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
     *       @OA\JsonContent(ref="#/components/schemas/FuncionarioRemuneracaoTipoCadastrarValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarRemuneracaoTipo(FuncionarioRemuneracaoTipoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioRemuneracaoTipoCadastrarDTO::fromArray($validated);

            $tipo = $this->service->cadastrarRemuneracaoTipo($dto);

            return $this->sucessoResponse($tipo);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
