<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoMeioPagamentoAtualizarDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoMeioPagamentoCadastrarDTO;
use Modules\ContribuicaoSocios\app\Http\Resources\ContribuicaoMeioPagamentoAtivosResource;
use Modules\ContribuicaoSocios\app\Http\Resources\ContribuicaoMeioPagamentoResource;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoMeioDePagamentoService;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoMeioPagamentoAtualizarValidation;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoMeioPagamentoBuscarTodosParamsValidation;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoMeioPagamentoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Contribuição Meio de Pagamento",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class ContribuicaoMeioDePagamentoController extends BaseController
{

    public ContribuicaoMeioDePagamentoService $service;

    public function __construct(
        ContribuicaoMeioDePagamentoService $service
    )
    {

        $this->middleware(['auth:sanctum', 'ability:criar-meio-de-pagamento-de-contribuicao'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-meio-de-pagamento-de-contribuicao'])->only(['buscarTodosPaginado']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-meio-de-pagamento-de-contribuicao'])->only(['atualizar']);
        $this->middleware(['auth:sanctum', 'ability:criar-regras-de-pagamento-de-contribuicao'])->only(['buscarTodosParaFiltro']);
        $this->middleware(['auth:sanctum'])->except(['buscarMeioPagamentosAtivos']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/contribuicao/meio-pagamento",
     *     summary="Cadastra um meio de pagamento",
     *     tags={"Contribuição Meio de Pagamento"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContribuicaoMeioPagamentoCadastrarValidation")
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
    public function cadastrar(ContribuicaoMeioPagamentoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContribuicaoMeioPagamentoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/meio-pagamento",
     *     summary="Busca todos os meios de pagamento paginados",
     *     tags={"Contribuição Meio de Pagamento"},
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
    public function buscarTodosPaginado(ContribuicaoMeioPagamentoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PaginacaoFiltrosDTO::fromArray($validated);

            $buscados = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscados, ContribuicaoMeioPagamentoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/meio-pagamento/filtro",
     *     summary="Busca todos os meios de pagamento para usar como filtro",
     *     tags={"Contribuição Meio de Pagamento"},
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

            return $this->sucessoResponse( ContribuicaoMeioPagamentoResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/meio-pagamento/ativos",
     *     summary="Busca todos os meios de pagamentos ativos para usar",
     *     tags={"Contribuição Meio de Pagamento"},
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
    public function buscarMeioPagamentosAtivos()
    {
        try {
            $buscados = $this->service->buscarMeioPagamentosAtivos();

            return $this->sucessoResponse(ContribuicaoMeioPagamentoAtivosResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\Put(
     *     path="/contribuicao/meio-pagamento/{id}",
     *     summary="Atualizar um meio de pagamento",
     *     tags={"Contribuição Meio de Pagamento"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do meio de pagamento",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContribuicaoMeioPagamentoAtualizarValidation")
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
    public function atualizar(int $id, ContribuicaoMeioPagamentoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContribuicaoMeioPagamentoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
