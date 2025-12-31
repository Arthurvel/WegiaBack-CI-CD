<?php

namespace app\Http\Controllers\Configuracao;

use app\DTOs\Configuracao\EnderecoInstituicaoAtualizarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Configuracao\EnderecoInstituicaoResource;
use app\Services\Configuracao\EnderecoInstituicaoService;
use app\Validations\Configuracao\EnderecoInstituicaoAtualizarValidation;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Configuracao",
 *     description="Operações relacionadas as configuracoes da aplicacao"
 * )
 */
class EnderecoInstituicaoController extends BaseController
{

    private EnderecoInstituicaoService $service;

    public function __construct(EnderecoInstituicaoService $service)
    {
        $this->middleware(['auth:sanctum', 'ability:atualizar-endereco-da-instituicao'])->only(['atualizar']);
        $this->middleware('auth:sanctum')->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/configuracao/endereco-instituicao",
     *     summary="Buscar o endereco da instituicao",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function index() : JsonResponse
    {
        try {
            $endereco = $this->service->buscarOPrimeiro();

            return  $this->sucessoResponse( new EnderecoInstituicaoResource($endereco));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/configuracao/endereco-instituicao",
     *     summary="Atualiza um texto da aplicacao",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EnderecoInstituicaoAtualizarValidation")
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
    public function atualizar(EnderecoInstituicaoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = EnderecoInstituicaoAtualizarDTO::fromArray($validated);

            $this->service->cadastrarOuAtualizar($dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
