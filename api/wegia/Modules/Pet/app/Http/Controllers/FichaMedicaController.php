<?php

namespace Modules\Pet\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Pet\app\DTO\FichaMedicaAtualizarDTO;
use Modules\Pet\app\DTO\FichaMedicaCadastrarDTO;
use Modules\Pet\app\Services\FichaMedicaService;
use Modules\Pet\app\Validations\FichaMedicaAtualizarValidation;
use Modules\Pet\app\Validations\FichaMedicaCadastrarValidation;

class FichaMedicaController extends BaseController
{

    private FichaMedicaService $fichaMedicaService;

    public function __construct(
        FichaMedicaService $fichaMedicaService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-ficha-medica'])->only(['cadastrar']);
    $this->middleware(['auth:sanctum', 'ability:atualizar-ficha-medica'])->only(['atualizar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->fichaMedicaService = $fichaMedicaService;
    }

    /**
     * @OA\Post(
     *     path="/pet/{id}/ficha-medica",
     *     summary="Cadastra uma ficha medica no pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID do Pet",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FichaMedicaCadastrarValidation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ficha medica cadastrada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(int $id, FichaMedicaCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $fichaMedicaData = [
                'id_pet' => $id,
                ...$validated
            ];

            $fichaMedicaDto = FichaMedicaCadastrarDTO::fromArray($fichaMedicaData);

            $fichaMedica = $this->fichaMedicaService->criar($fichaMedicaDto);

            return $this->sucessoResponse($fichaMedica, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/pet/{id}/ficha-medica",
     *     summary="Atualizar a ficha medica do pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID do Pet",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FichaMedicaAtualizarValidation")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Ficha medica atualizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function atualizar(int $id, FichaMedicaAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $fichaMedicaDto = FichaMedicaAtualizarDTO::fromArray($validated);

            $this->fichaMedicaService->atualizarPorPet($id, $fichaMedicaDto);

            return $this->sucessoResponse(true, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
