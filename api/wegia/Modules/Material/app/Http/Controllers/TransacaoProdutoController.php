<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Material\app\DTO\TransacaoProdutoAtualizarDTO;
use Modules\Material\app\Services\TransacaoProdutoService;
use Modules\Material\app\Validations\TransacaoProdutoAtualizarValidation;

/**
 * @OA\Tag(
 *     name="Transacao Produto",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class TransacaoProdutoController extends BaseController
{

    public TransacaoProdutoService $service;

    public function __construct(
        TransacaoProdutoService $service
    )
    {
//        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
//        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Put(
     *     path="/material/transacao-produto/{id}",
     *     summary="Atualizar produto de uma transacao",
     *     tags={"Transacao Produto"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da transacao produto",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TransacaoProdutoAtualizarValidation")
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
    public function atualizar(Int $id, TransacaoProdutoAtualizarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = TransacaoProdutoAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id, $dto);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\delete(
     *     path="/material/transacao-produto/{id}",
     *     summary="Deletar produto de uma transacao",
     *     tags={"Transacao Produto"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID da transacao produto",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
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
    public function deletar(Int $id) : JsonResponse
    {
        try {
            $this->service->deletar($id);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
