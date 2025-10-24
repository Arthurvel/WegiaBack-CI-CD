<?php

namespace Modules\Material\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Material\app\DTO\ParceiroCadastrarDTO;
use Modules\Material\app\Http\Resources\ParceiroResource;
use Modules\Material\app\Services\ParceiroService;
use Modules\Material\app\Validations\ParceiroCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Almoxarifado",
 *     description="Operações relacionadas ao Modulo de material"
 * )
 */
class ParceiroController extends BaseController
{

    public ParceiroService $service;

    public function __construct(
        ParceiroService $service
    )
    {
//        $this->middleware(['auth:sanctum', 'ability:criar-saude-alergia'])->only(['cadastrar']);
//        $this->middleware(['auth:sanctum', 'ability:visualizar-saude-alergia'])->only(['buscarTodos']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/material/parceiro",
     *     summary="Cadastra um parceiro de transacao",
     *     tags={"Parceiro"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ParceiroCadastrarValidation")
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
    public function cadastrar(ParceiroCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = ParceiroCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/material/parceiro/filtros",
     *     summary="Buscar todas os parceiros para filtros",
     *     tags={"Parceiro"},
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
    public function buscarTodos()
    {
        try {
            $buscar = $this->service->buscarTodos();

            return $this->sucessoResponse(ParceiroResource::collection($buscar));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
