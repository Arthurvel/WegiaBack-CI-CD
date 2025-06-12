<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\CargoService;
use App\Validations\Cargo\CriarCargoValidacao;
use App\Validations\Situacao\CriarSituacaoValidacao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Cargo",
 *     description="Operações relacionadas ao Cargo do Funcionario"
 * )
 */
class CargoController extends BaseController
{

    protected $cargoService;

    public function __construct(
        CargoService $cargoService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->cargoService = $cargoService;
    }

     /**
     * @OA\Get(
     *     path="/cargo",
     *     summary="Buscar os todos os Cargos",
     *     tags={"Cargo"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index() : JsonResponse
    {
        try {
            $cargos = $this->cargoService->pegarCargos();

            return  $this->sucessoResponse($cargos);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

    /**
     * @OA\Post(
     *     path="/cargo",
     *     summary="Cadastrar um novo cargo",
     *     tags={"Cargo"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cargo"},
     *             @OA\Property(property="cargo", type="string", maxLength=30, description="Nome do Cargo", example=""),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Cargo cadastrado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->all(),
                CriarCargoValidacao::rules(),
                CriarCargoValidacao::messages()
            );

            $cargo = $this->cargoService->criarCargo($request->cargo);

            return  $this->sucessoResponse($cargo, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }

    /**
     * @OA\Delete(
     *     path="/cargo/{id_cargo}",
     *     summary="Deletar um cargo",
     *     tags={"Cargo"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_cargo",
     *         in="path",
     *         description="ID do cargo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Cargo deletado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function destroy(int $id_cargo) : JsonResponse
    {
        try {
            $cargo = $this->cargoService->deletarSituacao($id_cargo);

            return  $this->sucessoResponse($cargo);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }
}
