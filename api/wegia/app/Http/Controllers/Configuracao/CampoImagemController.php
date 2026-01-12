<?php

namespace app\Http\Controllers\Configuracao;

use App\Http\Controllers\BaseController;
use app\Http\Resources\Configuracao\CampoImagemResource;
use app\Services\Configuracao\CampoImagemService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Configuracao",
 *     description="Operações relacionadas as configuracoes da aplicacao"
 * )
 */
class CampoImagemController  extends BaseController
{

    private CampoImagemService $service;

    public function __construct(CampoImagemService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/configuracao/campo-imagem",
     *     summary="Buscar os campos de imagens",
     *     tags={"Configuracao"},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function index() : JsonResponse
    {
        try {
            $contatos = $this->service->buscarTodos(['imagens']);

            return  $this->sucessoResponse( CampoImagemResource::collection($contatos));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
