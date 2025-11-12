<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeMedicacaoAtualizarDTO;
use Modules\Saude\app\DTO\SaudeMedicacaoBuscarTodosParamsDTO;
use Modules\Saude\app\Http\Resources\SaudeMedicamentoResource;
use Modules\Saude\app\Services\SaudeMedicacaoService;
use Modules\Saude\app\Validations\SaudeMedicacaoAtualizarValidation;
use Modules\Saude\app\Validations\SaudeMedicacaoBuscarTodosParamsValidation;


/**
 * @OA\Tag(
 *     name="Medicacao",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeMedicacaoController extends BaseController
{

    public SaudeMedicacaoService $service;

    public function __construct(
        SaudeMedicacaoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-medicacao'])->only(['buscar']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-saude-medicacao'])->only(['atualizar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\get(
     *     path="/saude/ficha-medica/{id}/medicacao",
     *     summary="Buscar todas os atendimentos de uma ficha medica",
     *     tags={"Medicacao"},
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
     *          description="Texto para busca por nome",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ordenacao",
     *          in="query",
     *          description="Campo de ordenação",
     *          required=false,
     *          @OA\Schema(type="string", enum={"medicamento", "dosagem", "horario", "duracao", "status"})
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
     *     @OA\Parameter(
     *           name="status",
     *           in="query",
     *           description="Status atual da medicacao",
     *           @OA\Schema(
     *              type="string",
     *              enum={"Tratamento", "Concluido", "Substituido", "Cancelado"}
     *           ),
     *           required=false,
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
    public function buscar(SaudeMedicacaoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeMedicacaoBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, SaudeMedicamentoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/saude/medicacao/{id}",
     *     summary="Atualizar um medicamento",
     *     tags={"Medicacao"},
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
     *          @OA\JsonContent(ref="#/components/schemas/SaudeMedicacaoAtualizarValidation")
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
    public function atualizar(SaudeMedicacaoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeMedicacaoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($validated['id_medicacao'], $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
