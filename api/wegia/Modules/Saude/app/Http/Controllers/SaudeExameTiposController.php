<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Saude\app\DTO\SaudeExameTipoDTO;
use Modules\Saude\app\Http\Resources\SaudeExameTipoResource;
use Modules\Saude\app\Services\SaudeExameTiposService;
use Modules\Saude\app\Validations\SaudeExameTipoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Exame",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeExameTiposController extends BaseController
{

    private SaudeExameTiposService $service;

    public function __construct(
        SaudeExameTiposService $service
    )
    {
        $this->middleware(['auth:sanctum'])->only(['']);
        $this->middleware(['auth:sanctum'])->except(['']);
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/exame-tipo",
     *     summary="Cadastra uma tipo de exame",
     *     tags={"Exame"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SaudeExameTipoCadastrarValidation")
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
    public function cadastrar(SaudeExameTipoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeExameTipoDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/saude/exame-tipo",
     *     summary="Buscar todos os tipos de exame",
     *     tags={"Exame"},
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
            $tipos = $this->service->buscarTodos();

            return $this->sucessoResponse(SaudeExameTipoResource::collection($tipos));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
