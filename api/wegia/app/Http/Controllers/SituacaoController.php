<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\SituacaoService;
use App\Validations\Situacao\CriarSituacaoValidacao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Situacao",
 *     description="Operações relacionadas a Situacao"
 * )
 */
class SituacaoController extends BaseController
{

    protected $situacaoService;

    public function __construct(
        SituacaoService $situacaoService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->situacaoService = $situacaoService;
    }

     /**
     * @OA\Get(
     *     path="/situacao",
     *     summary="Buscar os todas as situacoes",
     *     tags={"Situacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index() : JsonResponse
    {
        try {
            $situacoes = $this->situacaoService->pegarSituacoes();

            return  $this->sucessoResponse($situacoes);
        } catch (Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());
        } 
    }

    /**
     * @OA\Post(
     *     path="/situacao",
     *     summary="Cadastrar uma nova situacao",
     *     tags={"Situacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"situacao"},
     *             @OA\Property(property="situacao", type="string", maxLength=30, description="Nome da Situacao", example=""),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Sitacao cadastrada com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->all(),
                CriarSituacaoValidacao::rules(),
                CriarSituacaoValidacao::messages()
            );

            $situacoes = $this->situacaoService->criarSituacao($request->situacao);

            return  $this->sucessoResponse($situacoes, 201);
        } catch (Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());
        } 
    }

    /**
     * @OA\Delete(
     *     path="/situacao/{id_situacao}",
     *     summary="Deletar uma situacao",
     *     tags={"Situacao"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_situacao",
     *         in="path",
     *         description="ID da situacao",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Sitacao deletada com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function destroy(int $id_situacao) : JsonResponse
    {
        try {
            $situacoes = $this->situacaoService->deletarSituacao($id_situacao);

            return  $this->sucessoResponse($situacoes);
        } catch (Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());
        } 
    }
}
