<?php

namespace App\Http\Controllers;

use App\DTOs\Pessoa\PessoaAtualizarSenhaDTO;
use App\Validations\Pessoa\PessoaMudarSenhaValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\PessoaService;
use App\Validations\Pessoa\AtualizarPessoaValidation;
use App\Validations\Pessoa\CriarOuAtualizarImagemPessoaValidation;
use App\Validations\Pessoa\PessoaValidation;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Pessoa",
 *     description="Operações relacionadas as pessoas"
 * )
 */
class PessoaController extends BaseController
{
    private $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->middleware('auth:sanctum')->except(['create']);

        $this->pessoaService = $pessoaService;
    }


    /**
     * @OA\Post(
     *     path="/pessoa",
     *     summary="Cadastrar uma nova pessoa",
     *     tags={"Pessoa"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf"},
     *             @OA\Property(property="cpf", type="string", maxLength=11, description="CPF único"),
     *             @OA\Property(property="senha", type="string", maxLength=70, nullable=true, description="Senha do usuário"),
     *             @OA\Property(property="nome", type="string", maxLength=100, nullable=true, description="Nome do usuário"),
     *             @OA\Property(property="sobrenome", type="string", maxLength=100, nullable=true, description="Sobrenome do usuário"),
     *             @OA\Property(property="sexo", type="string", maxLength=1, nullable=true, description="Sexo do usuário"),
     *             @OA\Property(property="telefone", type="string", maxLength=25, nullable=true, description="Telefone de contato"),
     *             @OA\Property(property="data_nascimento", type="string", format="date", nullable=true, description="Data de nascimento"),
     *             @OA\Property(property="imagem", type="string", nullable=true, description="URL da imagem"),
     *             @OA\Property(property="cep", type="string", maxLength=10, nullable=true, description="CEP"),
     *             @OA\Property(property="estado", type="string", maxLength=5, nullable=true, description="Estado"),
     *             @OA\Property(property="cidade", type="string", maxLength=40, nullable=true, description="Cidade"),
     *             @OA\Property(property="bairro", type="string", maxLength=40, nullable=true, description="Bairro"),
     *             @OA\Property(property="logradouro", type="string", maxLength=100, nullable=true, description="Logradouro"),
     *             @OA\Property(property="numero_endereco", type="string", maxLength=80, nullable=true, description="Número do endereço"),
     *             @OA\Property(property="complemento", type="string", maxLength=50, nullable=true, description="Complemento"),
     *             @OA\Property(property="ibge", type="string", maxLength=20, nullable=true, description="Código IBGE"),
     *             @OA\Property(property="registro_geral", type="string", maxLength=120, nullable=true, description="Registro Geral (RG)"),
     *             @OA\Property(property="orgao_emissor", type="string", maxLength=120, nullable=true, description="Órgão emissor do RG"),
     *             @OA\Property(property="data_expedicao", type="string", format="date", nullable=true, description="Data de expedição do RG"),
     *             @OA\Property(property="nome_mae", type="string", maxLength=100, nullable=true, description="Nome da mãe"),
     *             @OA\Property(property="nome_pai", type="string", maxLength=100, nullable=true, description="Nome do pai"),
     *             @OA\Property(property="tipo_sanguineo", type="string", maxLength=5, nullable=true, description="Tipo sanguíneo"),
     *             @OA\Property(property="nivel_acesso", type="integer", nullable=true, description="Nível de acesso do usuário"),
     *             @OA\Property(property="adm_configurado", type="integer", nullable=true, description="Indica se o administrador está configurado")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function create(Request $request) : JsonResponse
    {

        try {

            $validator = Validator::make(
                $request->all(),
                PessoaValidation::rules(),
                PessoaValidation::messages()
            );

            if ($validator->fails()) {
                return $this->errorResponse(null, 422, $validator->errors());
            }

            $pessoa = $this->pessoaService->cadastrarPessoa($request->all());

            return $this->sucessoResponse($pessoa);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }

    }

    /**
     * @OA\Post(
     *     path="/pessoa/{id_pessoa}/imagem",
     *     summary="Cadastrar uma nova imagem para pessoa",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         description="ID da pessoa que deseja atualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"imagem"},
     *                 @OA\Property(
     *                     property="imagem",
     *                     type="string",
     *                     format="binary",
     *                     description="Imagem da pessoa para upload"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function cadastrarOuAtualizarImagem(Request $request, int $id_pessoa) : JsonResponse
    {
        try {

            $this->validarRequest(
                $request->all(),
                CriarOuAtualizarImagemPessoaValidation::rules(),
                CriarOuAtualizarImagemPessoaValidation::messages()
            );

            $pessoa = $this->pessoaService->cadastrarOuAtualizarImagem($request->only(['imagem']), $id_pessoa);

            return $this->sucessoResponse($pessoa);
        } catch (\Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }

    }

    /**
     * @OA\Get(
     *     path="/pessoa/{cpf}",
     *     summary="Buscar pessoa por cpf",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="cpf",
     *         in="path",
     *         description="cpf da pessoa",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Operação realizado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function buscarPessoaPorCpf(String $cpf) : JsonResponse
    {
        try {

            $pessoa = $this->pessoaService->buscarPessoaPorCpf($cpf);

            return $this->sucessoResponse($pessoa->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }

    }


    /**
     * @OA\Put(
     *     path="/pessoa/{id_pessoa}",
     *     summary="Atualizar uma pessoa",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         description="ID da pessoa que deseja atualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", maxLength=100, nullable=true, description="Nome do usuário"),
     *             @OA\Property(property="sobrenome", type="string", maxLength=100, nullable=true, description="Sobrenome do usuário"),
     *             @OA\Property(property="sexo", type="string", maxLength=1, nullable=true, description="Sexo do usuário"),
     *             @OA\Property(property="telefone", type="string", maxLength=25, nullable=true, description="Telefone de contato"),
     *             @OA\Property(property="data_nascimento", type="string", format="date", nullable=true, description="Data de nascimento"),
     *             @OA\Property(property="imagem", type="string", nullable=true, description="URL da imagem"),
     *             @OA\Property(property="cep", type="string", maxLength=10, nullable=true, description="CEP"),
     *             @OA\Property(property="estado", type="string", maxLength=5, nullable=true, description="Estado"),
     *             @OA\Property(property="cidade", type="string", maxLength=40, nullable=true, description="Cidade"),
     *             @OA\Property(property="bairro", type="string", maxLength=40, nullable=true, description="Bairro"),
     *             @OA\Property(property="logradouro", type="string", maxLength=100, nullable=true, description="Logradouro"),
     *             @OA\Property(property="numero_endereco", type="string", maxLength=80, nullable=true, description="Número do endereço"),
     *             @OA\Property(property="complemento", type="string", maxLength=50, nullable=true, description="Complemento"),
     *             @OA\Property(property="ibge", type="string", maxLength=20, nullable=true, description="Código IBGE"),
     *             @OA\Property(property="registro_geral", type="string", maxLength=120, nullable=true, description="Registro Geral (RG)"),
     *             @OA\Property(property="orgao_emissor", type="string", maxLength=120, nullable=true, description="Órgão emissor do RG"),
     *             @OA\Property(property="data_expedicao", type="string", format="date", nullable=true, description="Data de expedição do RG"),
     *             @OA\Property(property="nome_mae", type="string", maxLength=100, nullable=true, description="Nome da mãe"),
     *             @OA\Property(property="nome_pai", type="string", maxLength=100, nullable=true, description="Nome do pai"),
     *             @OA\Property(property="tipo_sanguineo", type="string", maxLength=5, nullable=true, description="Tipo sanguíneo"),
     *             @OA\Property(property="nivel_acesso", type="integer", nullable=true, description="Nível de acesso do usuário"),
     *             @OA\Property(property="adm_configurado", type="integer", nullable=true, description="Indica se o administrador está configurado")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function update(Request $request, int $id_pessoa)
    {
        try {
            $this->validarRequest(
                $request->all(),
                AtualizarPessoaValidation::rules(),
                AtualizarPessoaValidation::messages()
            );

            $pessoa = $this->pessoaService->atualizarPessoa($request->all(), $id_pessoa);

            return $this->sucessoResponse($pessoa);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/pessoa/senha",
     *     summary="Atualiza a propria senha",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *              @OA\Schema(ref="#/components/schemas/PessoaMudarSenhaValidation")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Pessoa atualizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function mudarPropriaSenha(PessoaMudarSenhaValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();
            $id = $request->user()->id_pessoa;

            $dto = PessoaAtualizarSenhaDTO::fromArray([
                "senha" => $validated['senha'],
                "id_pessoa" => $id
            ]);

            $pessoa = $this->pessoaService->mudarSenha($dto);

            return $this->sucessoResponse(true, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/pessoa/logada",
     *     summary="Retorna a pessoa autenticado",
     *     tags={"Pessoa"},
     *     @OA\Parameter(
     *         name="with",
     *         in="query",
     *         description="Separados por virgula",
     *         required=false,
     *         @OA\Schema(type="string", default="")
     *     ),
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Usuário retornado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Operação realizada com sucesso!"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id_pessoa", type="integer", example=""),
     *                 @OA\Property(property="cpf", type="string", example=""),
     *                 @OA\Property(property="nome", type="string", example=""),
     *                 @OA\Property(property="sobrenome", type="string", example=""),
     *                 @OA\Property(property="sexo", type="string", example=""),
     *                 @OA\Property(property="telefone", type="string", example=""),
     *                 @OA\Property(property="data_nascimento", type="string", format="date-time", example=""),
     *                 @OA\Property(property="imagem", type="string", nullable=true, example=null),
     *                 @OA\Property(property="cep", type="string", example=""),
     *                 @OA\Property(property="estado", type="string", example=""),
     *                 @OA\Property(property="cidade", type="string", example=""),
     *                 @OA\Property(property="bairro", type="string", example=""),
     *                 @OA\Property(property="logradouro", type="string", example=""),
     *                 @OA\Property(property="numero_endereco", type="string", example=""),
     *                 @OA\Property(property="complemento", type="string", nullable=true, example=null),
     *                 @OA\Property(property="ibge", type="string", nullable=true, example=null),
     *                 @OA\Property(property="registro_geral", type="string", example=""),
     *                 @OA\Property(property="orgao_emissor", type="string", example=""),
     *                 @OA\Property(property="data_expedicao", type="string", format="date-time", example=""),
     *                 @OA\Property(property="nome_mae", type="string", example=""),
     *                 @OA\Property(property="nome_pai", type="string", example=""),
     *                 @OA\Property(property="tipo_sanguineo", type="string", example=""),
     *                 @OA\Property(property="nivel_acesso", type="integer", example=""),
     *                 @OA\Property(property="adm_configurado", type="integer", example=""),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Usuário não autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="message", example="Mensagem de erro"),
     *             @OA\Property(property="data", type="data", example=null)
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro no servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="message", example="Mensagem de erro"),
     *             @OA\Property(property="data", type="data", example=null)
     *         ),
     *     ),
     * )
     */
    public function retornarPessoaLogada(Request $request) : JsonResponse
    {
        try {
            $with   = isset($request->with) ? explode(',', $request->with) : [];
            $pessoa = $request->user()->load($with);

            return $this->sucessoResponse($pessoa);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
