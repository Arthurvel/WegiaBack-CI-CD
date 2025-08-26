<?php

namespace App\Http\Controllers\Funcionario;

use app\DTOs\Funcionario\QuadroHorario\FuncionarioQuadroHorarioCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Funcionario\FuncionarioQuadroHorarioEscalaResource;
use app\Http\Resources\Funcionario\FuncionarioQuadroHorarioResource;
use app\Http\Resources\Funcionario\FuncionarioQuadroHorarioTipoResource;
use app\Services\Funcionario\FuncionarioQuadroHorarioService;
use App\Services\FuncionarioService;
use app\Validations\Funcionario\QuadroHorario\FuncionarioQuadroHorarioCadastrarValidation;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioQuadroHorarioController extends BaseController
{

    protected FuncionarioQuadroHorarioService $service;
    protected FuncionarioService $funcionarioService;

    public function __construct(
        FuncionarioQuadroHorarioService $service,
        FuncionarioService $funcionarioService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-funcionario-quadro-horario'])->only(['buscarQuadroHorarioPorFuncionario']);
        $this->middleware(['auth:sanctum', 'ability:criar-funcionario-quadro-horario'])->only(['create', 'buscarEscalaQuadroHorario', 'buscarTipoQuadroHorario']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
        $this->funcionarioService = $funcionarioService;
    }

    /**
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}/quadro-horario",
     *     summary="Buscar o quadro horario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do Funcionario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarQuadroHorarioPorFuncionario(int $id_funcionario) : JsonResponse
    {
        try {
            $quadroHorario = $this->service->buscarQuadroHorarioPorFuncionario($id_funcionario);

            return $this->sucessoResponse(new FuncionarioQuadroHorarioResource($quadroHorario));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/{id_funcionario}/quadro-horario",
     *     summary="Cadastrar o quadro horario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do Funcionario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/FuncionarioQuadroHorarioCadastrarValidation")
     *      ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(FuncionarioQuadroHorarioCadastrarValidation $request, int $id_funcionario) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioQuadroHorarioCadastrarDTO::fromArray([
                ...$validated,
                'id_funcionario' => $id_funcionario
            ]);

            $remuneracaoTipo = $this->service->cadastrarQuadroHorario($dto);

            return $this->sucessoResponse($remuneracaoTipo, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/quadro-horario/escala",
     *     summary="Buscar escala de quadro horário",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function buscarEscalaQuadroHorario() : JsonResponse
    {
        try {
            $escala = $this->service->buscarEscalaQuadroHorario();

            return $this->sucessoResponse(FuncionarioQuadroHorarioEscalaResource::collection($escala));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/quadro-horario/tipo",
     *     summary="Buscar is tipos de quadro horário",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function buscarTipoQuadroHorario() : JsonResponse
    {
        try {
            $tipo = $this->service->buscarTipoQuadroHorario();

            return $this->sucessoResponse(FuncionarioQuadroHorarioTipoResource::collection($tipo));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
