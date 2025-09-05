<?php

namespace App\Http\Controllers\Atendido;

use App\Http\Controllers\BaseController;
use app\Services\Atendido\AtendidoService;
use app\Services\Atendido\AtendidoStatusService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Atendido",
 *     description="Operações relacionadas dos atendidos"
 * )
 */
class AtendidoStatusController extends BaseController
{

    protected AtendidoStatusService $service;

    public function __construct(
        AtendidoStatusService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-status-de-atendido'])->only(['index']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

     /**
     * @OA\Get(
     *     path="/atendido/status",
     *     summary="Buscar os todos os status de atendimento",
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

            return  $this->sucessoResponse($atendidos);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }


}
