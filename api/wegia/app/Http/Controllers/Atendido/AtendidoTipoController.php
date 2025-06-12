<?php

namespace App\Http\Controllers\Atendido;

use App\Http\Controllers\BaseController;
use App\Services\AtendidoService;
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

    protected $atendidoService;

    public function __construct(
        AtendidoService $atendidoService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->atendidoService = $atendidoService;
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
            $atendidos = $this->atendidoService->buscarTipoAtendimento();

            return  $this->sucessoResponse($atendidos);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

    
}
