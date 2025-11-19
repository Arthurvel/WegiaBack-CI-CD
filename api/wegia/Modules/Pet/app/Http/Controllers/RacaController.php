<?php

namespace Modules\Pet\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Pet\app\DTO\RacaCadastrarDTO;
use Modules\Pet\app\Services\RacaService;
use Modules\Pet\app\Validations\RacaCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Raca",
 *     description="Operações relacionadas ao Modulo de Pet"
 * )
 */
class RacaController extends BaseController
{

    private RacaService $racaService;

    public function __construct(
        RacaService $racaService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-raca'])->only(['create']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-raca'])->only(['index']);

        $this->racaService = $racaService;
    }

    /**
     * @OA\Get(
     *     path="/raca",
     *     summary="Buscar os todas as Racas",
     *     tags={"Raca"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="OpeRacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function index() : JsonResponse
    {
        try {
            $raca = $this->racaService->buscarTodos();

            return  $this->sucessoResponse($raca);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/raca",
     *     summary="Cadastrar as racas",
     *     tags={"Raca"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RacaCadastrarValidation")
     *     ),
     *     @OA\Response(response="201", description="OpeRacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function create(RacaCadastrarValidation $request) : JsonResponse
    {
        try{
            $validated = $request->validated();

            $dto = RacaCadastrarDTO::fromArray($validated);

            $raca = $this->racaService->criar($dto);

            return $this->sucessoResponse($raca,201);
        }catch(\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
