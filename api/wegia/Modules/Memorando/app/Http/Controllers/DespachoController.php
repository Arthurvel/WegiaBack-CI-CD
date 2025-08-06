<?php

namespace Modules\Memorando\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Modules\Memorando\app\DTO\DespachoCadastrarDTO;
use Modules\Memorando\app\Services\DespachoService;
use Modules\Memorando\app\Validations\DespachoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Despacho",
 *     description="Operações relacionadas ao Modulo de Memorando"
 * )
 */
class DespachoController extends BaseController
{

    private DespachoService $despachoService;
    public function __construct(
        DespachoService $despachoService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-memorando'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum'])->only(['index']);

        $this->despachoService = $despachoService;
    }


    /**
     * @OA\Post(
     *     path="/despacho/memorando/{id}",
     *     summary="Cadastra um despacho a partir de um memorando",
     *     tags={"Despacho"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="Id do Memorando",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/DespachoCadastrarValidation")
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Despacho cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(int $id, DespachoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();
            $anexos = $request->file('anexos') ?? [];

            $despachoData = [
                'texto'            => $validated['texto'],
                'id_memorando'    => $id,
                'id_destinatario'  => $validated['id_destinatario'],
                'id_remetente'     => $request->user()->id_pessoa,
            ];

            $despachoDTO = DespachoCadastrarDTO::fromArray($despachoData);

            $despachoCriado = $this->despachoService->criarComAnexos($despachoDTO, $request->user()->id_pessoa, $anexos);

            return $this->sucessoResponse($despachoCriado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
