<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\ContribuicaoSocios\app\DTO\PagamentoCadastrarDTO;
use Modules\ContribuicaoSocios\app\Http\Resources\PagamentoCriadoResource;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoConjuntoRegras;
use Modules\ContribuicaoSocios\app\Services\PagamentoService;
use Modules\ContribuicaoSocios\app\Validations\PagamentoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Pagamento",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class PagamentoController extends BaseController
{

    protected PagamentoService $pagamentoService;

    public function __construct(
        PagamentoService $pagamentoService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:sincronizar-pagamentos'])->only(['sincronizarPagamento']);
        $this->pagamentoService = $pagamentoService;
    }

    /**
     * @OA\Post(
     *     path="/contribuicao/pagamento",
     *      summary="Cadastrar um pagamento",
     *     tags={"Pagamento"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PagamentoCadastrarValidation")
     *      ),
     *     @OA\Response(
     *         response=201,
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
    public function criarPagamento(PagamentoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PagamentoCadastrarDTO::fromArray($validated);

            $criado = $this->pagamentoService->criarPagamento($dto);

            return $this->sucessoResponse(PagamentoCriadoResource::collection($criado), 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/contribuicao/pagamento/sincronizar",
     *      summary="Sincroniza os pagamentos com as apis cadastradas",
     *     tags={"Pagamento"},
     *     security={{"bearerAuth": {}}},
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
    public function sincronizarPagamento()
    {
        try {
            $sincronizado = $this->pagamentoService->sincronizarPagamento();

            return $this->sucessoResponse($sincronizado, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
