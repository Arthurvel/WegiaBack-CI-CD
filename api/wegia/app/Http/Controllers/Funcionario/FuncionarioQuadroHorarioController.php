<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\BaseController;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\CriarQuadroHorarioFuncionarioValidation;
use App\Validations\Funcionario\IdFuncionarioValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioQuadroHorarioController extends BaseController
{

    protected $funcionarioService;

    public function __construct(
        FuncionarioService $funcionarioService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

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
            $this->validarRequest(
                ["id_funcionario" => $id_funcionario],
                IdFuncionarioValidation::rules(),
                IdFuncionarioValidation::messages()
            );

            $remuneracao = $this->funcionarioService->buscarQuadroHorarioPorFuncionario($id_funcionario);

            return $this->sucessoResponse($remuneracao->toArray());
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
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_escala", "id_tipo"},
     *             @OA\Property(property="id_escala", type="integer", description="ID da escala", example=2),
     *             @OA\Property(property="id_tipo", type="integer", description="ID do tipo de quadro horário", example=3),
     *             @OA\Property(property="carga_horaria", type="string", maxLength=200, nullable=true, description="Carga horária do funcionário", example="08:00"),
     *             @OA\Property(property="entrada1", type="string", maxLength=200, nullable=true, description="Primeira entrada do funcionário", example="09:00"),
     *             @OA\Property(property="saida1", type="string", maxLength=200, nullable=true, description="Primeira saída do funcionário", example="12:00"),
     *             @OA\Property(property="entrada2", type="string", maxLength=200, nullable=true, description="Segunda entrada do funcionário", example="13:00"),
     *             @OA\Property(property="saida2", type="string", maxLength=200, nullable=true, description="Segunda saída do funcionário", example="17:00"),
     *             @OA\Property(property="total", type="string", maxLength=200, nullable=true, description="Total de horas trabalhadas", example="08:00"),
     *             @OA\Property(property="dias_trabalhados", type="string", maxLength=200, nullable=true, description="Dias trabalhados pelo funcionário", example="5"),
     *             @OA\Property(property="folga", type="string", maxLength=200, nullable=true, description="Dias de folga do funcionário", example="2")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request, int $id_funcionario) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    "id_funcionario" => $id_funcionario,
                    ...$request->all()
                ],
                CriarQuadroHorarioFuncionarioValidation::rules(),
                CriarQuadroHorarioFuncionarioValidation::messages()
            );

            $remuneracaoTipo = $this->funcionarioService->cadastrarQuadroHorario($request->all(), $id_funcionario);

            return $this->sucessoResponse($remuneracaoTipo);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
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
            // $this->validarRequest(
            //     $request->all(),
            //     CriarRemuneracaoTipoFuncionarioValidation::rules(),
            //     CriarRemuneracaoTipoFuncionarioValidation::messages()
            // );

            $escala = $this->funcionarioService->buscarEscalaQuadroHorario();

            return $this->sucessoResponse($escala);
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
            $tipo = $this->funcionarioService->buscarTipoQuadroHorario();

            return $this->sucessoResponse($tipo);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
