<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\OrigemCadastrarDTO;
use Modules\Material\app\Services\OrigemService;
use Modules\Material\app\Validations\OrigemCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Origem",
 *     description="Operações relacionadas ao Modulo de Material"
 * )
 */
class OrigemController extends BaseController
{

    private OrigemService $origemService;
    public function __construct(
        OrigemService $origemService
    )
    {
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->origemService = $origemService;
    }

    /**
     * @OA\Get(
     *     path="/origem/todos",
     *     summary="Buscar todas as origens ",
     *     tags={"Origem"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operação realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function todos() : JsonResponse
    {
        try {
            $todos = $this->origemService->buscarTodos();

            return $this->sucessoResponse($todos);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/origem",
     *     summary="Cadastra a origem do material",
     *     tags={"Origem"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/OrigemCadastrarValidation")
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Orgem cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(OrigemCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = OrigemCadastrarDTO::fromArray($validated);

            $criado = $this->origemService->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
