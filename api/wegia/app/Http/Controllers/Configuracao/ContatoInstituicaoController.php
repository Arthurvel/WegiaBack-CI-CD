<?php

namespace app\Http\Controllers\Configuracao;

use app\DTOs\Configuracao\ContatoInstituicaoAtualizarDTO;
use app\DTOs\Configuracao\ContatoInstituicaoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Configuracao\ContatoInstituicaoResource;
use app\Services\Configuracao\ContatoInstituicaoService;
use app\Validations\Configuracao\ContatoInstituicaoAtualizarValidation;
use app\Validations\Configuracao\ContatoInstituicaoCadastrarValidation;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Configuracao",
 *     description="Operações relacionadas as configuracoes da aplicacao"
 * )
 */
class ContatoInstituicaoController extends BaseController
{

    private ContatoInstituicaoService $service;

    public function __construct(ContatoInstituicaoService $service)
    {
        $this->middleware(['auth:sanctum', 'ability:cadastrar-contato-da-instituicao'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-contato-da-instituicao'])->only(['atualizar']);
        $this->middleware(['auth:sanctum', 'ability:deletar-contato-da-instituicao'])->only(['deletar']);
        $this->middleware('auth:sanctum')->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/configuracao/contato-instituicao",
     *     summary="Buscar os contatos da instituicao",
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
            $contatos = $this->service->buscarTodos();

            return  $this->sucessoResponse( ContatoInstituicaoResource::collection($contatos));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/configuracao/contato-instituicao",
     *     summary="Cadastrar um contato da instituicao",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContatoInstituicaoCadastrarValidation")
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
    public function cadastrar(ContatoInstituicaoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContatoInstituicaoCadastrarDTO::fromArray($validated);

            $this->service->criar($dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/configuracao/contato-instituicao/{id}",
     *     summary="Atualiza um contato da instituicao",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do contato da instituicao",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContatoInstituicaoAtualizarValidation")
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
    public function atualizar(int $id, ContatoInstituicaoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ContatoInstituicaoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete (
     *     path="/configuracao/contato-instituicao/{id}",
     *     summary="Deleta um contato da instituicao",
     *     tags={"Configuracao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID do contato da instituicao",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
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
    public function deletar(int $id)
    {
        try {
            $this->service->deletar($id);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
