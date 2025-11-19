<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeMedicacaoAdministracaoBuscarTodosParamDTO;
use Modules\Saude\app\DTO\SaudeMedicamentoAdministracaoCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeMedicamentoAdministracaoResource;
use Modules\Saude\app\Services\SaudeMedicamentoAdministracaoService;
use Modules\Saude\app\Validations\SaudeMedicacaoAdministracaoBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeMedicacaoAdministracaoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Medicacao",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeMedicamentoAdministracaoController extends BaseController
{

    public SaudeMedicamentoAdministracaoService $service;

    public function __construct(
        SaudeMedicamentoAdministracaoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-medicamento-administracao'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-medicamento-administracao'])->only(['buscarTodosPaginado']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/medicacao/{id}/aplicacao",
     *     summary="Cadastra um medico",
     *     tags={"Medicacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da medicacao",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SaudeMedicacaoAdministracaoCadastrarValidation")
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
    public function cadastrar(SaudeMedicacaoAdministracaoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeMedicamentoAdministracaoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/medicacao/{id}/aplicacao",
     *     summary="Buscar historico de administracao do medicamento",
     *     tags={"Medicacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da medicacao",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
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
    public function buscarTodosPaginado(SaudeMedicacaoAdministracaoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeMedicacaoAdministracaoBuscarTodosParamDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, SaudeMedicamentoAdministracaoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
