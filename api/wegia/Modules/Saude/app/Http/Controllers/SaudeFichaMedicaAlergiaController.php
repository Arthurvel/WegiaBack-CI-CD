<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeFichaMedicaAlergiaBuscarTodosParamsDTO;
use Modules\Saude\app\DTO\SaudeFichaMedicaAlergiaCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeFichaMedicaAlergiaResource;
use Modules\Saude\app\Services\SaudeFichaMedicaAlergiaService;
use Modules\Saude\app\Validations\SaudeFichaMedicaAlergiaBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeFichaMedicaAlergiaCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Alergia",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeFichaMedicaAlergiaController extends BaseController
{

    public SaudeFichaMedicaAlergiaService $service;

    public function __construct(
        SaudeFichaMedicaAlergiaService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:cadastrar-saude-alergia-na-ficha-medica'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia-na-ficha-medica'])->only(['buscarTodosPaginado']);
        $this->middleware(['auth:sanctum', 'ability:deletar-saude-alergia-na-ficha-medica'])->only(['deletar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica/{id_fichamedica}/alergia/{id_alergia}",
     *     summary="Cadastra uma alergia",
     *     tags={"Alergia"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_fichamedica",
     *          in="path",
     *          description="ID da ficha medica",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *           name="id_alergia",
     *           in="path",
     *           description="ID da alergia",
     *           required=true,
     *           @OA\Schema(type="integer")
     *     ),
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
    public function cadastrar(SaudeFichaMedicaAlergiaCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeFichaMedicaAlergiaCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/ficha-medica/{id}/alergia",
     *     summary="Buscar todas as alergias de uma ficha medica",
     *     tags={"Alergia"},
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
     *          description="Campo de ordenação (nome)",
     *          required=false,
     *          @OA\Schema(type="string", enum={"nome"})
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
    public function buscarTodosPaginado(SaudeFichaMedicaAlergiaBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeFichaMedicaAlergiaBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse(new PaginacaoResource($buscar, SaudeFichaMedicaAlergiaResource::class) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\delete(
     *     path="/saude/ficha-medica/alergia/{id}",
     *     summary="Deleta uma alergia da ficha medica",
     *     tags={"Alergia"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da alergia",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
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
    public function deletar(int $id)
    {
        try {
            $this->service->deletar($id);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
