<?php

namespace Modules\ContribuicaoSocios\app\Http\Controllers;

use App\DTOs\PaginacaoFiltrosDTO;
use App\DTOs\Pessoa\PessoaAtualizarDTO;
use app\DTOs\Pessoa\PessoaCadastrarDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Modules\ContribuicaoSocios\app\DTO\SocioAtualizarDTO;
use Modules\ContribuicaoSocios\app\DTO\SocioCadastrarDTO;
use Modules\ContribuicaoSocios\app\Http\Resources\SocioResource;
use Modules\ContribuicaoSocios\app\Services\SocioService;
use Modules\ContribuicaoSocios\app\Validations\SocioAtualizarValidation;
use Modules\ContribuicaoSocios\app\Validations\SocioBuscarTodosPaginadoParamsValidation;
use Modules\ContribuicaoSocios\app\Validations\SocioCadastrarValidation;
use Modules\ContribuicaoSocios\app\Validations\SocioPessoaCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Socio",
 *     description="Operações relacionadas ao Modulo de Contribuicao e Socios"
 * )
 */
class SocioController extends BaseController
{

    public SocioService $service;

    public function __construct(
        SocioService $service
    )
    {
        //$this->middleware(['auth:sanctum', 'ability:criar-regras-de-pagamento-de-contribuicao'])->only(['buscarTodosParaFiltro']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/socio",
     *      summary="Cadastrar um socio",
     *     tags={"Socio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SocioCadastrarValidation")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(SocioCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = SocioCadastrarDTO::fromArray($validated);

            $criado = $this->service->criar($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/socio/pessoa",
     *      summary="Cadastrar uma pessoa com socio",
     *     tags={"Socio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SocioPessoaCadastrarValidation")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrarSocioPessoa(SocioPessoaCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $socioDTO  = SocioCadastrarDTO::fromArray([
                ...$validated,
                'id_pessoa' => 0
            ]);
            $pessoaDTO = PessoaCadastrarDTO::fromArray($validated);

            $criado = $this->service->criarSocioPessoa($socioDTO, $pessoaDTO);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\Get(
     *     path="/socio",
     *     summary="Busca todos os socios paginados",
     *     tags={"Socio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="buscar",
     *           in="query",
     *           description="Texto para busca por nome da plataforma",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *           name="ordenacao",
     *           in="query",
     *           description="Campo de ordenação",
     *           required=false,
     *           @OA\Schema(type="string", enum={ "nome", "email", "telefone", "endereco", "cpf", "tipo" })
     *       ),
     *       @OA\Parameter(
     *           name="tipoOrdenacao",
     *           in="query",
     *           description="Tipo de ordenação ASC ou DESC",
     *           required=false,
     *           @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *       ),
     *       @OA\Parameter(
     *           name="pagina",
     *           in="query",
     *           description="Número da página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
     *       @OA\Parameter(
     *           name="itensPorPagina",
     *           in="query",
     *           description="Quantidade de itens por página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarTodosPaginado(SocioBuscarTodosPaginadoParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PaginacaoFiltrosDTO::fromArray($validated);

            $buscados = $this->service->buscarTodosPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscados, SocioResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/socio/aniversariante",
     *     summary="Busca todos os socios aniversariantes paginados",
     *     tags={"Socio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="buscar",
     *           in="query",
     *           description="Texto para busca por nome da plataforma",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *       @OA\Parameter(
     *           name="ordenacao",
     *           in="query",
     *           description="Campo de ordenação",
     *           required=false,
     *           @OA\Schema(type="string", enum={ "nome", "email", "telefone", "endereco", "cpf", "tipo" })
     *       ),
     *       @OA\Parameter(
     *           name="tipoOrdenacao",
     *           in="query",
     *           description="Tipo de ordenação ASC ou DESC",
     *           required=false,
     *           @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *       ),
     *       @OA\Parameter(
     *           name="pagina",
     *           in="query",
     *           description="Número da página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
     *       @OA\Parameter(
     *           name="itensPorPagina",
     *           in="query",
     *           description="Quantidade de itens por página (mínimo 1)",
     *           required=false,
     *           @OA\Schema(type="integer", minimum=1)
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarTodosAniversariantesMesPaginado(SocioBuscarTodosPaginadoParamsValidation $request)
    {
        try {
            $validated = $request->validated();

            $dto = PaginacaoFiltrosDTO::fromArray($validated);

            $buscados = $this->service->buscarTodosAniversariantesMesPaginado($dto);

            return $this->sucessoResponse( new PaginacaoResource($buscados, SocioResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/socio/{id_socio}/pessoa/{id_pessoa}",
     *     summary="Atualizar uma tag do socio",
     *     tags={"Socio"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id_socio",
     *            in="path",
     *            description="ID do socio",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *             name="id_pessoa",
     *             in="path",
     *             description="ID da pessoa",
     *             required=true,
     *             @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SocioAtualizarValidation")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Operacao realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function atualizarComPessoa(int $id_socio, int $id_pessoa, SocioAtualizarValidation $request)
    {
        try {
            $validated = $request->validated();

            $socioDTO  = SocioAtualizarDTO::fromArray($validated);
            $pessoaDTO = PessoaAtualizarDTO::fromArray($validated);

            $this->service->atualizarComPessoa($id_socio, $id_pessoa, $socioDTO, $pessoaDTO);

            return $this->sucessoResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
