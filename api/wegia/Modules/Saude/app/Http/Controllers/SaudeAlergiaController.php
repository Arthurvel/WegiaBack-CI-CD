<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Saude\app\DTO\SaudeAlergiaBuscarTodosParamsDTO;
use Modules\Saude\app\DTO\SaudeAlergiaCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeAlergiaResource;
use Modules\Saude\app\Services\SaudeAlergiaService;
use Modules\Saude\app\Validations\SaudeAlergiaBuscarTodosParamsValidation;
use Modules\Saude\app\Validations\SaudeAlergiaCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Alergia",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeAlergiaController extends BaseController
{

    public SaudeAlergiaService $service;

    public function __construct(
        SaudeAlergiaService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/alergia",
     *     summary="Cadastra uma alergia",
     *     tags={"Alergia"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SaudeAlergiaCadastrarValidation")
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
    public function cadastrar(SaudeAlergiaCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeAlergiaCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/alergia",
     *     summary="Buscar todas as alergias para filtros",
     *     tags={"Alergia"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_fichamedica",
     *          in="query",
     *          description="id da ficha medica para trazer os que a ficha medica nao tem",
     *          required=false,
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
    public function buscarTodos(SaudeAlergiaBuscarTodosParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeAlergiaBuscarTodosParamsDTO::fromArray($validated);

            $buscar = $this->service->buscarTodosSemOsCadastrados($dto);

            return $this->sucessoResponse(SaudeAlergiaResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
