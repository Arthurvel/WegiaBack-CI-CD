<?php

namespace app\Http\Controllers\Pessoa;

use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\DTOs\Pessoa\PessoaAtualizarSenhaDTO;
use App\DTOs\Pessoa\PessoaComFotoCadastrarDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Pessoa\PessoaResource;
use app\Services\Pessoa\PessoaService;
use app\Validations\Pessoa\PessoaAtualizarValidation;
use App\Validations\Pessoa\PessoaCadastrarValidation;
use app\Validations\Pessoa\PessoaImagemAtualizarValidation;
use app\Validations\Pessoa\PessoaLogadaValidation;
use App\Validations\Pessoa\PessoaMudarSenhaValidation;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Pessoa",
 *     description="Operações relacionadas as pessoas"
 * )
 */
class PessoaController extends BaseController
{
    private PessoaService $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->middleware(['auth:sanctum', 'ability:criar-pessoa'])->only(['create']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-pessoa'])->only(['buscarPessoaPorCpf']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-senha-de-outras-pessoas'])->only(['mudarSenhaDeFuncionarios']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-pessoa'])->only(['cadastrarOuAtualizarImagem', 'update']);
        $this->middleware('auth:sanctum')->except([]);

        $this->pessoaService = $pessoaService;
    }


    /**
     * @OA\Post(
     *     path="/pessoa",
     *     summary="Cadastrar uma nova pessoa",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/PessoaCadastrarValidation")
     *           )
     *      ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function create(PessoaCadastrarValidation $request) : JsonResponse
    {

        try {
            $validated = $request->validated();

            $dto = PessoaComFotoCadastrarDTO::fromArray($validated);

            $pessoa = $this->pessoaService->cadastrarPessoaComFoto($dto);

            return $this->sucessoResponse($pessoa, 201);
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
     *           required=true,
     *            @OA\MediaType(
     *                mediaType="multipart/form-data",
     *                @OA\Schema(ref="#/components/schemas/PessoaImagemAtualizarValidation")
     *            )
     *      ),
     *     @OA\Response(response="200", description="Cadastro realizado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function cadastrarOuAtualizarImagem(PessoaImagemAtualizarValidation $request, int $id_pessoa) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $pessoa = $this->pessoaService->atualizarImagem($request->only(['imagem']), $id_pessoa);

            return $this->sucessoResponse($pessoa, 201);
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

            return $this->sucessoResponse(new PessoaResource($pessoa));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/pessoa/filtro",
     *     summary="Buscar pessoa para filtro",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operação realizado com sucesso"),
     *     @OA\Response(response="422", description="Erro de validação"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function buscarPessoaParaFiltros() : JsonResponse
    {
        try {
            $pessoas = $this->pessoaService->buscarPessoaParaFiltros();

            return $this->sucessoResponse($pessoas);
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
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/PessoaAtualizarValidation")
     *       ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function update(PessoaAtualizarValidation $request, int $id_pessoa)
    {
        try {
            $validated = $request->validated();

            $dto = PessoaAtualizarDTO::fromArray($validated);

            $this->pessoaService->atualizar($id_pessoa, $dto);

            return $this->sucessoResponse(true, 204);
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
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PessoaMudarSenhaValidation")
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
     * @OA\Put(
     *     path="/pessoa/{id}/senha",
     *     summary="Atualiza a senha de outras pessoas",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PessoaMudarSenhaValidation")
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
    public function mudarSenhaDeFuncionarios(int $id, PessoaMudarSenhaValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

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
     *           response=200,
     *           description="Operação realizada com sucesso",
     *           @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="Usuário não autenticado",
     *           @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro no servidor",
     *         @OA\JsonContent(),
     *     ),
     * )
     */
    public function retornarPessoaLogada(PessoaLogadaValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $with   = isset($validated['with']) ? explode(',', $validated['with']) : [];
            $pessoa = $request->user()->load($with);

            return $this->sucessoResponse(new PessoaResource($pessoa));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
