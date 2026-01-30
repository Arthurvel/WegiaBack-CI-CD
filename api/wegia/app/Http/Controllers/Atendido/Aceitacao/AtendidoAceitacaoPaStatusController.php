<?php

namespace app\Http\Controllers\Atendido\Aceitacao;

use App\Http\Controllers\BaseController;
use app\Http\Resources\Atendido\Aceitacao\AtendidoAceitacaoPaStatusResource;
use app\Services\Atendido\Aceitacao\AtendidoAceitacaoPaStatusService;

class AtendidoAceitacaoPaStatusController extends BaseController
{

    protected AtendidoAceitacaoPaStatusService $paStatusService;

    public function __construct(
        AtendidoAceitacaoPaStatusService $paStatusService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->paStatusService = $paStatusService;
    }

    /**
     * @OA\Get(
     *     path="/atendido/aceitacao/status",
     *     summary="Buscar o status de aceitacao dos atendidos",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function index()
    {
        try {
            $status = $this->paStatusService->buscarTodos();

            return  $this->sucessoResponse( AtendidoAceitacaoPaStatusResource::collection($status) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
