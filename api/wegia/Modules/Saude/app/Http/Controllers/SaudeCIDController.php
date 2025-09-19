<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Saude\app\DTO\SaudeCIDCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeCIDResource;
use Modules\Saude\app\Services\SaudeCIDService;
use Modules\Saude\app\Validations\SaudeCIDCadastrarValidation;

/**
 * @OA\Tag(
 *     name="CID",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeCIDController extends BaseController
{

    private SaudeCIDService $service;

    public function __construct(
        SaudeCIDService $service
    )
    {
        $this->middleware(['auth:sanctum'])->only(['']);
        $this->middleware(['auth:sanctum'])->except(['']);
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/cid",
     *     summary="Cadastra uma cid",
     *     tags={"CID"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SaudeCIDCadastrarValidation")
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
    public function cadastrar(SaudeCIDCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeCIDCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/saude/cid",
     *     summary="Buscar todos os cid",
     *     tags={"CID"},
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
    public function buscarTodos()
    {
        try {
            $cids = $this->service->buscarTodos();

            return $this->sucessoResponse(SaudeCIDResource::collection($cids));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
