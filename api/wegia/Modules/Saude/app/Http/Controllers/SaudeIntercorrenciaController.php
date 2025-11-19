<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeIntercorrenciaBuscarTodosParamsDTO;
use Modules\Saude\app\DTO\SaudeIntercorrenciaCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeIntercorrenciaResource;
use Modules\Saude\app\Services\SaudeIntercorrenciaService;
use Modules\Saude\app\Validations\SaudeIntercorrenciaBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeIntercorrenciaCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Intercorrencia",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeIntercorrenciaController extends BaseController
{

    public SaudeIntercorrenciaService $service;

    public function __construct(
        SaudeIntercorrenciaService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-intercorrencia'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-intercorrencia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica/{id}/intercorrencia",
     *     summary="Cadastra uma intercorrencia",
     *     tags={"Intercorrencia"},
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
     *          @OA\JsonContent(ref="#/components/schemas/SaudeIntercorrenciaCadastrarValidation")
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
    public function cadastrar(SaudeIntercorrenciaCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeIntercorrenciaCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/ficha-medica/{id}/intercorrencia",
     *     summary="Buscar todas as intercorrencias de uma ficha medica",
     *     tags={"Intercorrencia"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da ficha medica",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
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
    public function buscarTodos(SaudeIntercorrenciaBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeIntercorrenciaBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, SaudeIntercorrenciaResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
