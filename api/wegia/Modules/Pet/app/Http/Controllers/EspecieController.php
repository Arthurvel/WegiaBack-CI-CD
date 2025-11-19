<?php

namespace Modules\Pet\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Pet\app\DTO\EspecieCadastrarDTO;
use Modules\Pet\app\DTO\RacaCadastrarDTO;
use Modules\Pet\app\Services\EspecieService;
use Modules\Pet\app\Validations\EspecieCadastrarValidation;
use Modules\Pet\app\Validations\RacaCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Especie",
 *     description="Operações relacionadas ao Modulo de Pet"
 * )
 */
class EspecieController extends BaseController
{

    private EspecieService $especieService;

    public function __construct(
        EspecieService $especieService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-especie'])->only(['create']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-especie'])->only(['index']);

        $this->especieService = $especieService;
    }

    /**
     * @OA\Get(
     *     path="/especie",
     *     summary="Buscar os todas as Especies",
     *     tags={"Especie"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="OpeRacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function index() : JsonResponse
    {
        try {
            $raca = $this->especieService->buscarTodos();

            return  $this->sucessoResponse($raca);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/especie",
     *     summary="Cadastrar a Especie",
     *     tags={"Especie"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EspecieCadastrarValidation")
     *     ),
     *     @OA\Response(response="201", description="OpeRacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function create(EspecieCadastrarValidation $request) : JsonResponse
    {
        try{
            $validated = $request->validated();

            $dto = EspecieCadastrarDTO::fromArray($validated);

            $especie = $this->especieService->criar($dto);

            return $this->sucessoResponse($especie,201);
        }catch(\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
