<?php

namespace App\Http\Controllers\Funcionario;

use app\DTOs\Funcionario\Infos\FuncionarioInfosBuscarDTO;
use app\DTOs\Funcionario\Infos\FuncionarioInfosCadastrarDTO;
use app\DTOs\Funcionario\Infos\FuncionarioListaInfoDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Funcionario\FuncionarioInfoResource;
use app\Http\Resources\Funcionario\FuncionarioListaInfoResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Funcionario\FuncionarioInfoService;
use app\Validations\Funcionario\infos\FuncionarioInfosCadastrarValidation;
use app\Validations\Funcionario\infos\FuncionarioListaInfoCadastrarValidation;
use App\Validations\PaginacaoValidation;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * @OA\Tag(
 *     name="Funcionario",
 *     description="Operações relacionadas aos funcionarios"
 * )
 */
class FuncionarioInfoController extends BaseController
{

    protected FuncionarioInfoService $service;

    public function __construct(
        FuncionarioInfoService $service,
    )
    {
        $this->middleware(['auth:sanctum', 'ability:visualizar-outras-informacoes-do-funcionario'])->only(['buscarInfosPorIdFuncionario', 'pegarListaInfo']);
        $this->middleware(['auth:sanctum', 'ability:criar-outras-informacoes-do-funcionario'])->only(['create', 'cadastrarListaInfo']);
        $this->middleware(['auth:sanctum', 'ability:deletar-outras-informacoes-do-funcionario'])->only(['destroy']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/funcionario/{id_funcionario}/outra-info",
     *     summary="Busca todas as informações de um funcionario",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do Funcionario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Dado ou Descricao do item e da lista para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (descricao, dados)",
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
    public function buscarInfosPorIdFuncionario(PaginacaoValidation $request, int $id_funcionario) : JsonResponse
    {
        try {

            $validated = $request->validated();

            $dto = FuncionarioInfosBuscarDTO::fromArray($validated);
            $dto->id_funcionario = $id_funcionario;

            $info = $this->service->buscarInfosPorIdFuncionario($dto);

            return $this->sucessoResponse(new PaginacaoResource($info, FuncionarioInfoResource::class));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/{id_funcionario}/outra-info/{id_funcionario_lista_info}",
     *     summary="Cadastra um novo item na lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id_funcionario",
     *         in="path",
     *         description="ID do Funcionario",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="id_funcionario_lista_info",
     *         in="path",
     *         description="ID do item na lista de informacoes",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/FuncionarioInfosCadastrarValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function create(FuncionarioInfosCadastrarValidation $request, int $id_funcionario, int $id_funcionario_lista_info) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioInfosCadastrarDTO::fromArray([
                ...$validated,
                'funcionario_id_funcionario' => $id_funcionario,
                'funcionario_listainfo_idfuncionario_listainfo' => $id_funcionario_lista_info
            ]);

            $info = $this->service->criar($dto);

            return $this->sucessoResponse($info, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/funcionario/outra-info/{id_funcionario_outrasinfo}",
     *     summary="Deletar um item na lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id_funcionario_outrasinfo",
     *         in="path",
     *         description="ID da outra informacao",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function destroy(int $id_funcionario_outrasinfo) : JsonResponse
    {
        try {
            $this->service->deletar($id_funcionario_outrasinfo);

            return $this->sucessoResponse(true, 204);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/lista-info",
     *     summary="Busca todos os itens da lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function pegarListaInfo() : JsonResponse
    {
        try {
            $listaInfo = $this->service->pegarListaInfo();

            return $this->sucessoResponse(FuncionarioListaInfoResource::collection($listaInfo));
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/lista-info",
     *     summary="Cadastra um novo item na lista de informacoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/FuncionarioListaInfoCadastrarValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrarListaInfo(FuncionarioListaInfoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = FuncionarioListaInfoDTO::fromArray($validated);

            $listaCriada = $this->service->cadastrarListaInfo($dto);

            return $this->sucessoResponse($listaCriada, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
