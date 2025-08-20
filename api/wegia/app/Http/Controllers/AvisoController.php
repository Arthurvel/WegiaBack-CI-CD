<?php

namespace App\Http\Controllers;

use App\DTOs\Aviso\AvisoBuscarTodosParamsDTO;
use App\Http\Resources\Aviso\AvisoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use App\Services\AvisoService;
use App\Validations\Aviso\AvisoBuscarTodosValidation;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Aviso",
 *     description="Operações relacionadas aos Avisos"
 * )
 */
class AvisoController extends BaseController
{

    private AvisoService $service;

    public function __construct(AvisoService $service)
    {
        $this->middleware('auth:sanctum')->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/aviso",
     *     summary="Buscar os avisos daquele usuário",
     *     tags={"Aviso"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="ativo",
     *         in="query",
     *         description="Filtra se o aviso está ativo (true ou false)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"true", "false"})
     *     ),
     *     @OA\Parameter(
     *         name="titulo",
     *         in="query",
     *         description="Filtra avisos pelo título",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="nivel",
     *         in="query",
     *         description="Filtra avisos pelo nível",
     *         required=false,
     *         @OA\Schema(type="string", enum={"info", "alerta", "erro"})
     *     ),
     *     @OA\Parameter(
     *         name="pagina",
     *         in="query",
     *         description="Número da página para paginação",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Quantidade de itens por página",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação realizada com sucesso!",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function  index(AvisoBuscarTodosValidation $request) : JsonResponse
    {
        try {
            $dto = AvisoBuscarTodosParamsDTO::fromArray($request->validated());

            $dto->id_pessoa = $request->user()->id_pessoa;

            $avisos = $this->service->buscarTodosFiltro($dto);

            return $this->sucessoResponse(new PaginacaoResource($avisos, AvisoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/aviso/{id}",
     *     summary="Buscar os avisos daquele usuário",
     *     tags={"Aviso"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id do aviso",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação realizada com sucesso!",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarPorId(Int $id) : JsonResponse
    {
        try {
            $aviso = $this->service->buscarPorId($id);

            return $this->sucessoResponse(new AvisoResource($aviso));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\Put(
     *     path="/aviso/{id}",
     *     summary="Atualizar o status do id",
     *     tags={"Aviso"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do aviso",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Operação realizado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function desativar(int $id) : JsonResponse
    {
        try {
            $this->service->desativar($id);

            return $this->sucessoResponse(null, 204, "Aviso desativado com sucesso!");
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }



}
