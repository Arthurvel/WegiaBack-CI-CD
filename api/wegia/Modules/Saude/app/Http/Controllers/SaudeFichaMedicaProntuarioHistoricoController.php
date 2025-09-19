<?php

namespace Modules\Saude\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Saude\app\Services\SaudeFichaMedicaProntuarioHistoricoService;

class SaudeFichaMedicaProntuarioHistoricoController extends BaseController
{

    private SaudeFichaMedicaProntuarioHistoricoService $service;

    public function __construct(
        SaudeFichaMedicaProntuarioHistoricoService $service
    )
    {
        $this->middleware(['auth:sanctum'])->only(['']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/saude/ficha-medica/{id}/historico",
     *     summary="Cadastra uma Historico do prontuario medica",
     *     tags={"Saude Ficha Medica"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da ficha medica",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Historico cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastar(int $id)
    {
        try {
            $criado = $this->service->criarHistorico($id);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


}
