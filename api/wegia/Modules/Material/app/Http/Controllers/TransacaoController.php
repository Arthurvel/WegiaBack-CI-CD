<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\TransacaoAtualizarDTO;
use Modules\Material\app\DTO\TransacaoBuscarTodosParamsDTO;
use Modules\Material\app\DTO\TransacaoCadastrarDTO;
use Modules\Material\app\Http\Resources\TransacaoResource;
use Modules\Material\app\Services\TransacaoService;
use Modules\Material\app\Validations\TransacaoAtualizarValidation;
use Modules\Material\app\Validations\TransacaoBuscarTodosParamsValidation;
use Modules\Material\app\Validations\TransacaoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Transacao",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class TransacaoController extends BaseController
{

    public TransacaoService $service;

    public function __construct(
        TransacaoService $service
    )
    {
//        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
//        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/transacao",
     *     summary="Cadastra uma transacao",
     *     tags={"Transacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TransacaoCadastrarValidation")
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
    public function cadastrar(TransacaoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $transacaoDTO = TransacaoCadastrarDTO::fromArray([
                'id_tipo_movimentacao' => $validated['id_tipo_movimentacao'],
                'id_almoxarifado'      => $validated['id_almoxarifado'],
                'id_parceiro'          => $validated['id_parceiro'],
                'id_responsavel'       => $request->user()->id_pessoa
            ]);

            $criado = $this->service->criarTransacaoComProduto($transacaoDTO, $validated['produtos']);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/transacao",
     *     summary="Buscar todas as transacoes paginados",
     *     tags={"Transacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="buscar",
     *          in="query",
     *          description="Texto para busca por nome",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Parameter(
     *           name="tipo",
     *           in="query",
     *           description="Tipo de movimentacao",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *      @OA\Parameter(
     *          name="ordenacao",
     *          in="query",
     *          description="Campo de ordenação",
     *          required=false,
     *          @OA\Schema(type="string", enum={"data", "descricao_produto", "descricao_almoxarifado", "descricao_tipo_movimentacao"})
     *      ),
     *      @OA\Parameter(
     *          name="tipoOrdenacao",
     *          in="query",
     *          description="Tipo de ordenação ASC ou DESC",
     *          required=false,
     *          @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *      ),
     *      @OA\Parameter(
     *          name="pagina",
     *          in="query",
     *          description="Número da página (mínimo 1)",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *      ),
     *      @OA\Parameter(
     *          name="itensPorPagina",
     *          in="query",
     *          description="Quantidade de itens por página (mínimo 1)",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *      ),
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
    public function buscarTodosPaginado(TransacaoBuscarTodosParamsValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = TransacaoBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, TransacaoResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/material/transacao/{id}",
     *     summary="Atualiza uma transacao",
     *     tags={"Transacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da transcao",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TransacaoAtualizarValidation")
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
    public function atualizar(int $id, TransacaoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = TransacaoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
