<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoConjuntoRegrasAtualizarDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoConjuntoRegrasCadastrarDTO;
use Modules\ContribuicaoSocios\app\Http\Resources\ContribuicaoConjuntoRegrasResource;
use Modules\ContribuicaoSocios\app\Services\ContribuicaoConjuntoRegrasService;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoConjuntoRegrasAtualizarValidation;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoConjuntoRegrasBuscarTodosPaginadoParamsValidation;
use Modules\ContribuicaoSocios\app\Validations\ContribuicaoConjuntoRegrasCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Contribuição Regras",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class ContribuicaoConjuntoRegrasController extends BaseController
{

    public ContribuicaoConjuntoRegrasService $service;

    public function __construct(
        ContribuicaoConjuntoRegrasService $service
    )
    {

//        $this->middleware(['auth:sanctum', 'ability:criar-almoxarifado-do-material'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/contribuicao/regra/meio-pagamento",
     *     summary="Atribua uma regra a um meio de pagamento",
     *     tags={"Contribuição Regras"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContribuicaoConjuntoRegrasCadastrarValidation")
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
    public function cadastrar(ContribuicaoConjuntoRegrasCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContribuicaoConjuntoRegrasCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/contribuicao/regra/meio-pagamento/{id}",
     *     summary="Atualizar uma regra de um meio de pagamento",
     *     tags={"Contribuição Regras"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da regra de um meio de pagamento",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContribuicaoConjuntoRegrasAtualizarValidation")
     *      ),
     *     @OA\Response(
     *         response=204,
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
    public function atualizar(int $id, ContribuicaoConjuntoRegrasAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContribuicaoConjuntoRegrasAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/contribuicao/regra/meio-pagamento",
     *     summary="Busca todos as regras dos meios de pagamento paginados",
     *     tags={"Contribuição Regras"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="buscar",
     *           in="query",
     *           description="Texto para busca por meio de pagamento e regra",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *           name="ordenacao",
     *           in="query",
     *           description="Campo de ordenação",
     *           required=false,
     *           @OA\Schema(type="string", enum={"regra", "meio", "valor"})
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
    public function buscarTodosPaginado(ContribuicaoConjuntoRegrasBuscarTodosPaginadoParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PaginacaoFiltrosDTO::fromArray($validated);

            $buscados = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscados, ContribuicaoConjuntoRegrasResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
