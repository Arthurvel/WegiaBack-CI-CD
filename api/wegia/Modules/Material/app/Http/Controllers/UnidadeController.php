<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\UnidadeCadastrarDTO;
use Modules\Material\app\Http\Resources\UnidadeResource;
use Modules\Material\app\Services\UnidadeService;
use Modules\Material\app\Validations\UnidadeCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Almoxarifado",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class UnidadeController extends BaseController
{

    public UnidadeService $service;

    public function __construct(
        UnidadeService $service
    )
    {
//        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
//        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/unidade",
     *     summary="Cadastra uma unidade",
     *     tags={"Unidade"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UnidadeCadastrarValidation")
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
    public function cadastrar(UnidadeCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = UnidadeCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/unidade/filtros",
     *     summary="Buscar todas as unidades para filtros",
     *     tags={"Unidade"},
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
    public function buscarTodos() : JsonResponse
    {
        try {
            $buscar = $this->service->buscarTodos();

            return $this->sucessoResponse(UnidadeResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
