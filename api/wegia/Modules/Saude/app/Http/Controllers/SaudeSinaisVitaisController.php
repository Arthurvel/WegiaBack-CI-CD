<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeSinaisVitaisBuscarTodosParamsDTO;
use Modules\Saude\app\DTO\SaudeSinaisVitaisCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeSinaisVitaisResource;
use Modules\Saude\app\Services\SaudeSinaisVitaisService;
use Modules\Saude\app\Validations\SaudeSinaisVitaisBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeSinaisVitaisCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Sinais Vitais",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeSinaisVitaisController extends BaseController
{

    public SaudeSinaisVitaisService $service;

    public function __construct(
        SaudeSinaisVitaisService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-sinais-vitais'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-sinais-vitais'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica/{id}/sinal-vital",
     *     summary="Cadastra sinais vitais",
     *     tags={"Sinais Vitais"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da ficha medica",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SaudeSinaisVitaisCadastrarValidation")
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
    public function cadastrar(SaudeSinaisVitaisCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeSinaisVitaisCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/ficha-medica/{id}/sinal-vital",
     *     summary="Buscar todas os sinais vitais de uma ficha medica",
     *     tags={"Sinais Vitais"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da ficha medica",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\Parameter(
     *          name="buscar",
     *          in="query",
     *          description="Texto para busca por nome do funcionario",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ordenacao",
     *          in="query",
     *          description="Campo de ordenação (nome)",
     *          required=false,
     *          @OA\Schema(type="string", enum={"data", "saturacao", "pressao_arterial", "frequencia_cardiaca", "frequencia_respiratoria", "temperatura", "hgt"})
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
    public function buscarTodos(SaudeSinaisVitaisBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeSinaisVitaisBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, SaudeSinaisVitaisResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
