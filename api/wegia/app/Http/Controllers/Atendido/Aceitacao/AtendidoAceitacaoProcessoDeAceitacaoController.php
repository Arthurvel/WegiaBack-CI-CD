<?php

namespace app\Http\Controllers\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoBuscarTodosDTO;
use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoAtualizarDTO;
use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoCadastrarDTO;
use app\DTOs\Pessoa\PessoaCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Atendido\Aceitacao\AtendidoAceitacaoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoService;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoBuscarTodosValidation;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoAtualizarValidation;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoCadastrarValidation;

class AtendidoAceitacaoProcessoDeAceitacaoController extends BaseController
{

    protected AtendidoAceitacaoProcessoDeAceitacaoService $processoDeAceitacaoService;

    public function __construct(
        AtendidoAceitacaoProcessoDeAceitacaoService $processoDeAceitacaoService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->processoDeAceitacaoService = $processoDeAceitacaoService;
    }

    /**
     * @OA\Get(
     *     path="/atendido/aceitacao",
     *     summary="Buscar todos os processos de aceitação paginados",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="buscar",
     *          in="query",
     *          required=false,
     *          description="Texto para busca (nome, CPF, etc)",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          required=false,
     *          description="Status do processo de aceitação",
     *          @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *          name="itensPorPagina",
     *          in="query",
     *          required=false,
     *          description="Quantidade de itens por página",
     *          @OA\Schema(type="integer", example=10)
     *     ),
     *
     *     @OA\Parameter(
     *          name="pagina",
     *          in="query",
     *          required=false,
     *          description="Página atual",
     *          @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response="201", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function buscarTodos(AtendidoAceitacaoBuscarTodosValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoAceitacaoBuscarTodosDTO::fromArray($validated);

            $aceitacao = $this->processoDeAceitacaoService->buscarTodosPaginado($dto);

            return  $this->sucessoResponse( new PaginacaoResource($aceitacao, AtendidoAceitacaoResource::class)  );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/atendido/aceitacao/{id_processo}",
     *     summary="Buscar um processo de aceitação",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id_processo",
     *            in="path",
     *            description="Id do processo",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function buscarPorId(int $id_processo)
    {
        try {
            $aceitacao = $this->processoDeAceitacaoService->buscarPorId($id_processo, ['etapas.arquivos', 'etapas.status']);

            return  $this->sucessoResponse( new AtendidoAceitacaoResource($aceitacao) );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/atendido/aceitacao",
     *     summary="Cadastra uma pessoa no processo de aceitação",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AtendidoAceitacaoProcessoDeAceitacaoCadastrarValidation")
     *     ),
     *     @OA\Response(response="201", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrar(AtendidoAceitacaoProcessoDeAceitacaoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PessoaCadastrarDTO::fromArray($validated);

            $this->processoDeAceitacaoService->criarAceitacao($dto);

            return  $this->sucessoResponse( null, 201 );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/atendido/aceitacao/pessoa/{id_pessoa}",
     *     summary="Cadastra uma pessoa no processo de aceitação",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id_pessoa",
     *           in="path",
     *           description="Id da pessoa",
     *           required=true,
     *           @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarComPessoa(int $id_pessoa)
    {
        try {
            $atendidoAceitacaoDTO = AtendidoAceitacaoProcessoDeAceitacaoCadastrarDTO::fromArray([
                'data_inicio' => now()->format('Y-m-d'),
                'id_pessoa'   => $id_pessoa
            ]);

            $this->processoDeAceitacaoService->criarAceitacaoComPessoa($atendidoAceitacaoDTO);

            return  $this->sucessoResponse( null, 201 );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/atendido/aceitacao/{id}",
     *     summary="Atualizar uma aceitação",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/AtendidoAceitacaoProcessoDeAceitacaoAtualizarValidation")
     *     ),
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="Id da aceitacao",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function atualizar(AtendidoAceitacaoProcessoDeAceitacaoAtualizarValidation $request, int $id)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoAceitacaoProcessoDeAceitacaoAtualizarDTO::fromArray($validated);

            $this->processoDeAceitacaoService->atualizar($id, $dto);

            return  $this->sucessoResponse( null, 201 );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
