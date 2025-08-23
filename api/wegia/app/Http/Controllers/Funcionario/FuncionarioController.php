<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\BaseController;
use App\Services\FuncionarioService;
use App\Validations\Funcionario\BuscarFuncionarioValidation;
use App\Validations\Funcionario\CriarFuncionarioValidation;
use App\Validations\Pessoa\AtualizarPessoaValidation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioController extends BaseController
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
     *     path="/funcionario/todos",
     *     summary="Buscar por todos os funcionarios",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="permissao",
     *          in="query",
     *          description="Nome da permissao",
     *          required=false,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function buscarTodos(Request $request) : JsonResponse
    {
        try {
            $funcionario = $this->funcionarioService->buscarTodos($request->query('permissao'));

            return $this->sucessoResponse($funcionario);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario",
     *     summary="Buscar os funcionarios",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_situacao",
     *          in="query",
     *          description="Id da situacao do funcionario",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Nome, CPF ou Cargo do funcionário para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (nome, cpf, cargo)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tipoOrdenacao",
     *         in="query",
     *         description="Tipo de ordenação",
     *         required=false,
     *         @OA\Schema(type="string", default="ASC")
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Quantidade de funcionários por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="pagina",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->query(),
                BuscarFuncionarioValidation::rules(),
                BuscarFuncionarioValidation::messages()
            );

            $funcionario = $this->funcionarioService->pegarFuncionarios($request->query());

            return $this->sucessoResponse($funcionario);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}",
     *     summary="Buscar funcionario pelo id",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_funcionario",
     *          in="query",
     *          description="Id do funcionario",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function findById(int $id_funcionario) : JsonResponse
    {
        try {
            $id_funcionario = (int) $id_funcionario;

            $funcionario = $this->funcionarioService->pegarFuncionarioPorId($id_funcionario);

            return $this->sucessoResponse($funcionario);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario",
     *     summary="Cadastrar uma novo funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf", "nome", "sobrenome", "sexo", "telefone", "data_nascimento", "registro_geral", "orgao_emissor", "data_expedicao", "data_admissao", "id_situacao", "id_cargo", "id_escala", "id_tipo", "certificado_reservista_numero", "certificado_reservista_serie"},
     *             @OA\Property(property="cpf", type="string", maxLength=11, description="CPF único", example=""),
     *             @OA\Property(property="nome", type="string", maxLength=100, description="Nome do usuário", example=""),
     *             @OA\Property(property="sobrenome", type="string", maxLength=100, description="Sobrenome do usuário", example=""),
     *             @OA\Property(property="sexo", type="string", maxLength=1, description="Sexo do usuário", example=""),
     *             @OA\Property(property="telefone", type="string", maxLength=25, description="Telefone de contato", example=""),
     *             @OA\Property(property="data_nascimento", type="string", format="date", description="Data de nascimento", example=""),
     *             @OA\Property(property="registro_geral", type="string", maxLength=120, description="Registro Geral (RG)", example=""),
     *             @OA\Property(property="orgao_emissor", type="string", maxLength=120, description="Órgão emissor do RG", example=""),
     *             @OA\Property(property="data_expedicao", type="string", format="date", description="Data de expedição do RG", example=""),
     *             @OA\Property(property="imagem", type="string", nullable=true, description="URL da imagem", example=""),
     *             @OA\Property(property="data_admissao", type="string", format="date", description="Data de admissão", example=""),
     *             @OA\Property(property="id_situacao", type="integer", description="ID da situação", example=0),
     *             @OA\Property(property="id_perfil", type="integer", description="ID do perfil", example=0),
     *             @OA\Property(property="id_escala", type="integer", description="ID da escala", example=0),
     *             @OA\Property(property="id_tipo", type="integer", description="ID do tipo", example=0),
     *             @OA\Property(property="certificado_reservista_numero", type="string", maxLength=100, description="Número do certificado de reservista", example=""),
     *             @OA\Property(property="certificado_reservista_serie", type="string", maxLength=100, description="Série do certificado de reservista", example="")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->all(),
                CriarFuncionarioValidation::rules(),
                CriarFuncionarioValidation::messages()
            );

            $resultado = $this->funcionarioService->cadastrarFuncionario($request->all());

            return $this->sucessoResponse($resultado);

        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/funcionario/{id_funcionario}",
     *     summary="Atualizar um funcionario",
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
     *             @OA\Property(property="id_perfil", type="integer", description="ID do perfil"),
     *             @OA\Property(property="id_situacao", type="integer", description="ID da situação"),
     *             @OA\Property(property="data_admissao", type="string", format="date", description="Data de admissão"),
     *             @OA\Property(property="ctps", type="string", maxLength=150, description="Carteira de Trabalho"),
     *             @OA\Property(property="pis", type="string", maxLength=140, description="Número do PIS"),
     *             @OA\Property(property="uf_ctps", type="string", maxLength=20, description="UF da CTPS"),
     *             @OA\Property(property="numero_titulo", type="string", maxLength=150, description="Número do título de eleitor"),
     *             @OA\Property(property="zona", type="string", maxLength=30, description="Zona eleitoral"),
     *             @OA\Property(property="secao", type="string", maxLength=40, description="Seção eleitoral"),
     *             @OA\Property(property="certificado_reservista_numero", type="string", maxLength=100, description="Número do certificado de reservista"),
     *             @OA\Property(property="certificado_reservista_serie", type="string", maxLength=100, description="Série do certificado de reservista")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Funcionario atualizado realizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function update(Request $request, int $id_funcionario) : JsonResponse
    {
        try {
            $this->validarRequest(
                $request->all(),
                AtualizarPessoaValidation::rules(),
                AtualizarPessoaValidation::messages()
            );

            $resultado = $this->funcionarioService->atualizarFuncionario($request->all(), $id_funcionario);

            return $this->sucessoResponse($resultado);

        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
