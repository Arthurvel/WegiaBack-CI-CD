<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Material\app\Http\Resources\RelatorioProdutoResource;
use Modules\Material\app\DTO\RelatorioMaterialBuscarTodosParamsDTO;
use Modules\Material\app\DTO\RelatorioMaterialEstoqueBuscarTodosParamsDTO;
use Modules\Material\app\DTO\RelatorioMaterialProdutoBuscarTodosParamsDTO;
use Modules\Material\app\Http\Resources\RelatorioEstoqueResource;
use Modules\Material\app\Http\Resources\RelatorioResource;
use Modules\Material\app\Services\RelatorioService;
use Modules\Material\app\Validations\RelatorioMaterialBuscarTodosParamsValidation;
use Modules\Material\app\Validations\RelatorioMaterialEstoqueBuscarTodosParamsValidation;
use Modules\Material\app\Validations\RelatorioMaterialProdutoBuscarTodosParamsValidation;

/**
 * @OA\Tag(
 *     name="Relatorio",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class RelatorioController extends BaseController
{

    public RelatorioService $service;

    public function __construct(
        RelatorioService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-relatorio-material'])->only([
            'obterRelatorioMaterial',
            'obterRelatorioEstoque',
            'obterRelatorioProduto'
        ]);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\get(
     *     path="/material/relatorio",
     *     summary="Buscar o relatorio",
     *     tags={"Relatorio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="periodo_inicial",
     *          in="query",
     *          description="Periodo de inicio da busca",
     *          required=false,
     *          @OA\Schema(type="string",format="date")
     *      ),
     *     @OA\Parameter(
     *           name="periodo_final",
     *           in="query",
     *           description="Periodo de fim da busca",
     *           required=false,
     *           @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="id_tipo_movimentacao",
     *          in="query",
     *          description="id do tipo de movimentacao",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="tipo_movimentacao",
     *          in="query",
     *          description="Tipo de movimentacao realizada",
     *          required=false,
     *          @OA\Schema(type="string", enum={"e","s"})
     *      ),
     *      @OA\Parameter(
     *          name="id_parceiro",
     *          in="query",
     *          description="id da origem ou saida",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="id_responsavel",
     *          in="query",
     *          description="id do responsavel por criar",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *           name="id_almoxarifado",
     *           in="query",
     *           description="id do almoxarifado responsavel",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *     ),
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
    public function obterRelatorioMaterial(RelatorioMaterialBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = RelatorioMaterialBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->obterRelatorioMaterial($dto);

            return $this->sucessoResponse( RelatorioResource::collection($buscar) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/relatorio/estoque",
     *     summary="Buscar o relatorio do estoque",
     *     tags={"Relatorio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id_almoxarifado",
     *           in="query",
     *           description="id do almoxarifado responsavel",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *     ),
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
    public function obterRelatorioEstoque(RelatorioMaterialEstoqueBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = RelatorioMaterialEstoqueBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->obterRelatorioEstoque($dto);

            return $this->sucessoResponse( RelatorioEstoqueResource::collection($buscar) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/relatorio/produto",
     *     summary="Buscar o relatorio",
     *     tags={"Relatorio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="periodo_inicial",
     *          in="query",
     *          description="Periodo de inicio da busca",
     *          required=false,
     *          @OA\Schema(type="string",format="date")
     *      ),
     *     @OA\Parameter(
     *           name="periodo_final",
     *           in="query",
     *           description="Periodo de fim da busca",
     *           required=false,
     *           @OA\Schema(type="string", format="date")
     *      ),
     *     @OA\Parameter(
     *           name="id_almoxarifado",
     *           in="query",
     *           description="id do almoxarifado responsavel",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *            name="id_produto",
     *            in="query",
     *            description="id do produto",
     *            required=false,
     *            @OA\Schema(type="integer", minimum=1)
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
    public function obterRelatorioProduto(RelatorioMaterialProdutoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = RelatorioMaterialProdutoBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->obterRelatorioProduto($dto);

            return $this->sucessoResponse( RelatorioProdutoResource::collection($buscar) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
