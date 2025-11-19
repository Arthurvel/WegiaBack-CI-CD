<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoGatewayPagamentoAtualizarDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoGatewayPagamentoCadastrarDTO;
use Modules\ContribuicaoSocios\app\Http\Resources\ContribuicaoGatewayPagamentoResource;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoGatewayPagamentoService;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoGatewayPagamentoAtualizarValidation;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoGatewayPagamentoBuscarTodosPaginadoParamsValidation;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoGatewayPagamentoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Contribuição Gateway",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class ContribuicaoGatewayPagamentoController extends BaseController
{

    public ContribuicaoGatewayPagamentoService $service;

    public function __construct(
        ContribuicaoGatewayPagamentoService $service
    )
    {

        $this->middleware(['auth:sanctum', 'ability:criar-gateway-de-contribuicao'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-gateway-de-contribuicao'])->only(['buscarTodosPaginado']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-gateway-de-contribuicao'])->only(['atualizar']);

        $this->middleware(['auth:sanctum', 'ability:criar-meio-de-pagamento-de-contribuicao'])->only(['buscarTodosParaFiltro']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/contribuicao/gateway",
     *     summary="Cadastra um Gateway de pagamento",
     *     tags={"Contribuição Gateway"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContribuicaoGatewayPagamentoCadastrarValidation")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(ContribuicaoGatewayPagamentoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContribuicaoGatewayPagamentoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/gateway",
     *     summary="Busca todos os Gateway de pagamento paginados",
     *     tags={"Contribuição Gateway"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="buscar",
     *           in="query",
     *           description="Texto para busca por nome da plataforma",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *           name="ordenacao",
     *           in="query",
     *           description="Campo de ordenação",
     *           required=false,
     *           @OA\Schema(type="string", enum={"plataforma"})
     *       ),
     *       @OA\Parameter(
     *           name="tipoOrdenacao",
     *           in="query",
     *           description="Tipo de ordenação ASC ou DESC",
     *           required=false,
     *           @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *       ),
     *       @OA\Parameter(
     *           name="pagina",
     *           in="query",
     *           description="Número da página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
     *       @OA\Parameter(
     *           name="itensPorPagina",
     *           in="query",
     *           description="Quantidade de itens por página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarTodosPaginado(ContribuicaoGatewayPagamentoBuscarTodosPaginadoParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PaginacaoFiltrosDTO::fromArray($validated);

            $buscados = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscados, ContribuicaoGatewayPagamentoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/gateway/filtro",
     *     summary="Busca todos os Gateway de pagamento para usar como filtro",
     *     tags={"Contribuição Gateway"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarTodosParaFiltro()
    {
        try {
            $buscados = $this->service->buscarTodos();

            return $this->sucessoResponse( ContribuicaoGatewayPagamentoResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/contribuicao/gateway/{id}",
     *     summary="Atualizar um Gateway de pagamento",
     *     tags={"Contribuição Gateway"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do gateway de pagamento",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContribuicaoGatewayPagamentoAtualizarValidation")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function atualizar(int $id, ContribuicaoGatewayPagamentoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContribuicaoGatewayPagamentoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
