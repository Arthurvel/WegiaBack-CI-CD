<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeEnfermidadeAtualizarDTO;
use Modules\Saude\app\DTO\SaudeEnfermidadeBuscarParamsDTO;
use Modules\Saude\app\DTO\SaudeEnfermidadeCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeEnfermidadeResource;
use Modules\Saude\app\Services\SaudeEnfermidadesService;
use Modules\Saude\app\Validations\SaudeEnfermidadeAtualizarValidation;
use Modules\Saude\app\Validations\SaudeEnfermidadeBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeEnfermidadeCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Enfermidade",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeEnfermidadesController extends BaseController
{

    private SaudeEnfermidadesService $service;

    public function __construct(
        SaudeEnfermidadesService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-enfermidade'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-enfermidade'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-saude-enfermidade'])->only(['atualizar']);
        $this->middleware(['auth:sanctum'])->except(['']);
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica/{id}/enfermidade",
     *     summary="Cadastra uma enfermidade",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da ficha medica",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SaudeEnfermidadeCadastrarValidation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operacao cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(int $id, SaudeEnfermidadeCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeEnfermidadeCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/saude/ficha-medica/{id}/enfermidade",
     *     summary="Buscar todas as enfermidades de uma ficha medica",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da ficha medica",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *           name="buscar",
     *           in="query",
     *           description="Filtro de busca (CID, descricao)",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *      @OA\Parameter(
     *          name="ordenacao",
     *          in="query",
     *          description="Campo de ordenação (descricao, cid, data_diagnostico)",
     *          required=false,
     *          @OA\Schema(type="string", enum={"descricao", "CID", "data_diagnostico"})
     *      ),
     *      @OA\Parameter(
     *          name="tipoOrdenacao",
     *          in="query",
     *          description="Tipo de ordenação ASC ou DESC",
     *          required=false,
     *          @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *      ),
     *      @OA\Parameter(
     *           name="status",
     *           in="query",
     *           description="Ativo (1), Inativo (0)",
     *           required=false,
     *           @OA\Schema(type="integer", enum={1, 0})
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
     *         description="Operacao cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarTodos(int $id, SaudeEnfermidadeBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeEnfermidadeBuscarParamsDTO::fromArray([
                'id_fichamedica' => $id,
                ...$validated
            ]);

            $enfermidades = $this->service->buscarTodosPaginacao($dto);

            return $this->sucessoResponse(new PaginacaoResource($enfermidades, SaudeEnfermidadeResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\Put(
     *     path="/saude/ficha-medica/enfermidade/{id}",
     *     summary="Cadastra uma enfermidade",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da enfermidade",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SaudeEnfermidadeAtualizarValidation")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Operacao cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function atualizar(int $id, SaudeEnfermidadeAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeEnfermidadeAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
