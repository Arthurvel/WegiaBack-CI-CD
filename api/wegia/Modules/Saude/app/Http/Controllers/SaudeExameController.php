<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeExameBuscarParamsDTO;
use Modules\Saude\app\DTO\SaudeExameCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeExameResource;
use Modules\Saude\app\Services\SaudeExameService;
use Modules\Saude\app\Validations\SaudeExameBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeExameCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Exame",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeExameController extends BaseController
{

    private SaudeExameService $service;

    public function __construct(
        SaudeExameService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-exame'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-exame'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum', 'ability:deletar-saude-exame'])->only(['deletar']);
        $this->middleware(['auth:sanctum'])->except(['']);
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica/{id}/exame",
     *     summary="Cadastra um exame na ficha medica",
     *     tags={"Exame"},
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
     *         @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/SaudeExameCadastrarValidation")
     *         )
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
    public function cadastrar(int $id, SaudeExameCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();
            $arquivo = $request->file('arquivo') ?? null;

            $dto = SaudeExameCadastrarDTO::fromArray([
                'id_fichamedica' => $id,
                'arquivo'        => $arquivo,
                ...$validated
            ]);

            $criado = $this->service->criarComFoto($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/ficha-medica/{id}/exame",
     *     summary="Buscar todos os exames da ficha medica paginadas",
     *     tags={"Exame"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da ficha medica",
     *           required=true,
     *           @OA\Schema(type="integer")
     *     ),
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
     *          @OA\Schema(type="string", enum={"descricao", "arquivo_nome", "data"})
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
    public function buscarTodos(SaudeExameBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeExameBuscarParamsDTO::fromArray($validated);

            $exames = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse(new PaginacaoResource($exames, SaudeExameResource::class), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\delete(
     *     path="/saude/exame/{id}",
     *     summary="Buscar todos os exames da ficha medica paginadas",
     *     tags={"Exame"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID do exame",
     *           required=true,
     *           @OA\Schema(type="integer")
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
    public function deletar(int $id)
    {
        try {
            $this->service->deletarComFoto($id);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
