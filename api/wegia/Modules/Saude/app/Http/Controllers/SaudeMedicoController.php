<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Saude\app\DTO\SaudeMedicoCadastrarDTO;
use Modules\Saude\app\Http\Resources\SaudeMedicoResource;
use Modules\Saude\app\Services\SaudeMedicoService;
use Modules\Saude\app\Validations\SaudeMedicoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Medico",
 *     description="Operações relacionadas ao Modulo de Saude"
 * )
 */
class SaudeMedicoController extends BaseController
{

    public SaudeMedicoService $service;

    public function __construct(
        SaudeMedicoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-saude-medico'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-medico'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/medico",
     *     summary="Cadastra um medico",
     *     tags={"Medico"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SaudeMedicoCadastrarValidation")
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
    public function cadastrar(SaudeMedicoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SaudeMedicoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/saude/medico",
     *     summary="Buscar todos os medicos",
     *     tags={"Medico"},
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
            $medico = $this->service->buscarTodos();

            return $this->sucessoResponse(SaudeMedicoResource::collection($medico));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
