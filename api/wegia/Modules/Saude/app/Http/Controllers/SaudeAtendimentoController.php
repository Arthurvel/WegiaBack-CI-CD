<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeAtendimentoBuscarTodosParamsDTO;
use Modules\Saude\app\DTO\SaudeAtendimentoComMedicacaoCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeAtendimentoResource;
use Modules\Saude\app\Services\SaudeAtendimentoService;
use Modules\Saude\app\Validations\SaudeAtendimentoBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeAtendimentoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Atendimento",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeAtendimentoController extends BaseController
{

    public SaudeAtendimentoService $service;

    public function __construct(
        SaudeAtendimentoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-atendimento'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-atendimento'])->only(['buscar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica/{id}/atendimento",
     *     summary="Cadastra um atendimento",
     *     tags={"Atendimento"},
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
     *          @OA\JsonContent(ref="#/components/schemas/SaudeAtendimentoCadastrarValidation")
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
    public function cadastrarComMedicacao(SaudeAtendimentoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeAtendimentoComMedicacaoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criarComMedicacao($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/ficha-medica/{id}/atendimento",
     *     summary="Buscar todas os atendimentos de uma ficha medica",
     *     tags={"Atendimento"},
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
    public function buscar(SaudeAtendimentoBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeAtendimentoBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscar, SaudeAtendimentoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
