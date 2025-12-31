<?php

namespace App\Http\Controllers\Configuracao;

use app\DTOs\Configuracao\SelecaoParagrafoAtualizarDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Configuracao\SelecaoParagrafoResource;
use app\Services\Configuracao\SelecaoParagrafoService;
use app\Validations\Configuracao\SelecaoParagrafoAtualizarValidation;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * @OA\Tag(
 *     name="Configuracao",
 *     description="Operações relacionadas as configuracoes da aplicacao"
 * )
 */
class SelecaoParagrafoController extends BaseController
{

    private SelecaoParagrafoService $service;

    public function __construct(SelecaoParagrafoService $service)
    {
        $this->middleware(['auth:sanctum', 'ability:'])->only(['atualizar']);
        $this->middleware('auth:sanctum')->except(['index']);

        $this->service = $service;
    }


    /**
     * @OA\Get(
     *     path="/configuracao/selecao-paragrafo",
     *     summary="Buscar os textos da aplicacao",
     *     tags={"Configuracao"},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function index() : JsonResponse
    {
        try {
            $situacoes = $this->service->buscarTodos();

            return  $this->sucessoResponse( SelecaoParagrafoResource::collection($situacoes));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/configuracao/selecao-paragrafo/{id}",
     *     summary="Atualiza um texto da aplicacao",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da selecao paragrafo",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SelecaoParagrafoAtualizarValidation")
     *      ),
     *     @OA\Response(
     *         response=204,
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
    public function atualizar(int $id, SelecaoParagrafoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SelecaoParagrafoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
