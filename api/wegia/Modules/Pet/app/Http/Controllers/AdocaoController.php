<?php

namespace Modules\Pet\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Pet\app\DTO\AdocaoAtualizarDTO;
use Modules\Pet\app\DTO\AdocaoCadastrarDTO;
use Modules\Pet\app\Services\AdocaoService;
use Modules\Pet\app\Validations\AdocaoAtualizarValidation;
use Modules\Pet\app\Validations\AdocaoCadastrarValidation;

class AdocaoController extends BaseController
{

    private AdocaoService $adocaoService;

    public function __construct(
        AdocaoService $adocaoService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-adocao'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-adocao'])->only(['atualizar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->adocaoService = $adocaoService;
    }

    /**
     * @OA\Post(
     *     path="/pet/{id_pet}/adocao",
     *     summary="Cadastra um adotante para o pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_pet",
     *          in="path",
     *          description="ID do pet",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdocaoCadastrarValidation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Adocao cadastrada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(int $id_pet, AdocaoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $data = [
                'id_pet' => $id_pet,
                ...$validated
            ];

            $dto = AdocaoCadastrarDTO::fromArray($data);

            $criado = $this->adocaoService->criarComValidacao($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/pet/adocao/{id}",
     *     summary="Atualziar uma adocao de pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da adocao",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdocaoAtualizarValidation")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Adocao atualizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function atualizar(int $id,  AdocaoAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $data = [
                ...$validated
            ];

            $dto = AdocaoAtualizarDTO::fromArray($data);

            $this->adocaoService->atualizar($id, $dto);

            return $this->sucessoResponse(true, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
