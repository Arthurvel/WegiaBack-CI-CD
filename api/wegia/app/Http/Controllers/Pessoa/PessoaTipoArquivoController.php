<?php

namespace app\Http\Controllers\Pessoa;

use app\DTOs\Pessoa\Arquivo\PessoaTipoArquivoCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Pessoa\PessoaTipoArquivoResource;
use app\Services\Pessoa\PessoaTipoArquivoService;
use app\Validations\Pessoa\Arquivo\PessoaTipoArquivoCadastrarValidation;
use Illuminate\Http\JsonResponse;

class PessoaTipoArquivoController extends BaseController
{

    private PessoaTipoArquivoService $service;
    public function __construct(
        PessoaTipoArquivoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-tipo-de-arquivo'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-tipo-de-arquivo'])->only(['index']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/pessoa/arquivo/tipo",
     *     summary="Busca os tipos possiveis de arquivo",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
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
    public function index() : JsonResponse
    {
        try {
            $tipos = $this->service->buscarTodos();

            return $this->sucessoResponse(PessoaTipoArquivoResource::collection($tipos));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/pessoa/arquivo/tipo",
     *     summary="Cadastra um Arquivo na pessoa",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PessoaTipoArquivoCadastrarValidation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pet cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(PessoaTipoArquivoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = PessoaTipoArquivoCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
