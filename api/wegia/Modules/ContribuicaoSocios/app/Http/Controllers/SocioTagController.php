<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\ContribuicaoSocios\app\DTO\SocioTagCadastrarDTO;
use Modules\ContribuicaoSocios\app\Http\Resources\SocioTagResource;
use Modules\ContribuicaoSocios\app\Services\SocioTagService;
use Modules\ContribuicaoSocios\app\Validations\SocioTagAtualizarValidation;
use Modules\ContribuicaoSocios\app\Validations\SocioTagBuscarTodosPaginadoParamsValidation;
use Modules\ContribuicaoSocios\app\Validations\SocioTagCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Socio Tag",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class SocioTagController extends BaseController
{

    public SocioTagService $service;

    public function __construct(
        SocioTagService $service
    )
    {
        //$this->middleware(['auth:sanctum', 'ability:criar-regras-de-pagamento-de-contribuicao'])->only(['buscarTodosParaFiltro']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/socio/tag",
     *      summary="Cadastrar uma tag de socio",
     *     tags={"Socio Tag"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SocioTagCadastrarValidation")
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
    public function cadastrar(SocioTagCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SocioTagCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/socio/tag/filtro",
     *     summary="Busca todas as tags dos socios para usar como filtro",
     *     tags={"Socio Tag"},
     *     security={{"bearerAuth": {}}},
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
    public function buscarTodosParaFiltro()
    {
        try {
            $buscados = $this->service->buscarTodos();

            return $this->sucessoResponse( SocioTagResource::collection($buscados));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/socio/tag",
     *     summary="Busca todos as tags dos socios paginados",
     *     tags={"Socio Tag"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="buscar",
     *           in="query",
     *           description="Texto para busca por nome da plataforma",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *           name="ordenacao",
     *           in="query",
     *           description="Campo de ordenação",
     *           required=false,
     *           @OA\Schema(type="string", enum={"tag"})
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
    public function buscarTodosPaginado(SocioTagBuscarTodosPaginadoParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PaginacaoFiltrosDTO::fromArray($validated);

            $buscados = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscados, SocioTagResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/socio/tag/{id}",
     *     summary="Atualizar uma tag do socio",
     *     tags={"Socio Tag"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da tag",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SocioTagAtualizarValidation")
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
    public function atualizar(int $id, SocioTagAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SocioTagCadastrarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
