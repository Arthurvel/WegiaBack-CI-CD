<?php

namespace App\Http\Controllers\Atendido;

use App\Http\Controllers\BaseController;
use app\Http\Resources\Atendido\AtendidoTipoResource;
use app\Services\Atendido\AtendidoTipoService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Atendido",
 *     description="Operações relacionadas dos atendidos"
 * )
 */
class AtendidoTipoController extends BaseController
{

    protected AtendidoTipoService $service;

    public function __construct(
        AtendidoTipoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-tipo-de-atendido'])->only(['index']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

     /**
     * @OA\Get(
     *     path="/atendido/tipo",
     *     summary="Buscar os todos os tipos de atendimento",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index() : JsonResponse
    {
        try {
            $atendidos = $this->service->buscarTodos();

            return  $this->sucessoResponse(AtendidoTipoResource::collection($atendidos));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }


}
