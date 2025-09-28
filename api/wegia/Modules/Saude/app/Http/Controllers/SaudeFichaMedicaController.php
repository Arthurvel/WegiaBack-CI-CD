<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\Saude\app\DTO\SaudeFichaMedicaAtualizarDTO;
use Modules\Saude\app\DTO\SaudeFichaMedicaCadastrarDTO;
use Modules\Saude\app\DTO\SaudeFichaMedicaParamsDTO;
use Modules\Saude\app\Http\Resources\SaudeFichaMedicaResource;
use Modules\Saude\app\Services\SaudeFichaMedicaService;
use Modules\Saude\app\Validations\SaudeFichaMedicaAtualizarValidation;
use Modules\Saude\app\Validations\SaudeFichaMedicaCadastrarValidation;
use Modules\Saude\app\Validations\SaudeFichaMedicaParamsValidation;

/**
 * @OA\Tag(
 *     name="Saude Ficha Medica",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeFichaMedicaController extends BaseController
{

    private SaudeFichaMedicaService $service;

    public function __construct(
        SaudeFichaMedicaService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-ficha-medica'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-ficha-medica'])->only(['buscarPorId', 'buscarTodasFichasMedicas']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-saude-ficha-medica'])->only(['atualizarFichaMedica']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica",
     *     summary="Cadastra uma ficha medica",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SaudeFichaMedicaCadastrarValidation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ficha medica cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(SaudeFichaMedicaCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeFichaMedicaCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/ficha-medica/{id}",
     *     summary="Buscar uma ficha medica",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da ficha medica",
     *          required=true,
     *          @OA\Schema(type="integer")
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
    public function buscarPorId(int $id)
    {
        try {
            $with = ['historico', 'pessoa'];
            $ficha = $this->service->buscarPorId($id, $with);

            return $this->sucessoResponse(new SaudeFichaMedicaResource($ficha));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\get(
     *     path="/saude/ficha-medica",
     *     summary="Buscar todas as fichas medicas paginadas",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
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
    public function buscarTodasFichasMedicas(SaudeFichaMedicaParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeFichaMedicaParamsDTO::fromArray($validated);

            $fichas = $this->service->buscarFichaMedica($dto);

            return $this->sucessoResponse( new PaginacaoResource($fichas, SaudeFichaMedicaResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/saude/ficha-medica/{id}",
     *     summary="Atualizar uma ficha medica",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da ficha medica",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SaudeFichaMedicaAtualizarValidation")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Ficha medica cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function atualizarFichaMedica(int $id, SaudeFichaMedicaAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeFichaMedicaAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
