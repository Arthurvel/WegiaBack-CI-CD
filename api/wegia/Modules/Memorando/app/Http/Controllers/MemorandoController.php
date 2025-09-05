<?php

namespace Modules\Memorando\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Memorando\app\DTO\DespachoCadastrarDTO;
use Modules\Memorando\app\DTO\MemorandoAtualizarDTO;
use Modules\Memorando\app\DTO\MemorandoBuscarTodosDTO;
use Modules\Memorando\app\DTO\MemorandoCadastrarDTO;
use Modules\Memorando\app\Http\Resources\MemorandoEntradaResource;
use Modules\Memorando\app\Http\Resources\MemorandoResource;
use Modules\Memorando\app\Services\MemorandoService;
use Modules\Memorando\app\Validations\MemorandoAtualizarValidation;
use Modules\Memorando\app\Validations\MemorandoBuscarTodosValidation;
use Modules\Memorando\app\Validations\MemorandoCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Memorando",
 *     description="Operações relacionadas ao Memorando"
 * )
 */
class MemorandoController extends BaseController
{

    private MemorandoService $memorandoService;

    public function __construct(
        MemorandoService $memorandoService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-memorando'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-memorando'])->only(['index', 'memorandosParticipados', 'buscarProId']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-memorando'])->only(['atualizar']);
        $this->middleware('auth:sanctum')->except([]);

        $this->memorandoService = $memorandoService;
    }

    /**
     * @OA\Get(
     *     path="/memorando",
     *     summary="Buscar todos os memorandos",
     *     tags={"Memorando"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Texto para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenação",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tipoOrdenacao",
     *         in="query",
     *         description="Tipo da ordenação (ASC ou DESC)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status do memorando",
     *         required=false,
     *         @OA\Schema(type="string", enum={"Ativo","Lido","Não Lido","Importante","Pendente","Arquivado"})
     *     ),
     *     @OA\Parameter(
     *         name="destinatario",
     *         in="query",
     *         description="Filtrar por memorandos onde sou o destinatário",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="remetente",
     *         in="query",
     *         description="Filtrar por memorandos onde sou o remetente",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="pagina",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Itens por página",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function index(MemorandoBuscarTodosValidation $request) : JsonResponse
    {
        try {
            $dto = MemorandoBuscarTodosDTO::fromArray($request->validated());

            $dto->id_pessoa = $request->user()->id_pessoa;

            $memorandos = $this->memorandoService->buscarTodosFiltro($dto);

            return $this->sucessoResponse(new PaginacaoResource($memorandos, MemorandoEntradaResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/memorando/participados",
     *     summary="Buscar todos os memorandos participados por usuario logado",
     *     tags={"Memorando"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Texto para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenação",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tipoOrdenacao",
     *         in="query",
     *         description="Tipo da ordenação (ASC ou DESC)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status do memorando",
     *         required=false,
     *         @OA\Schema(type="string", enum={"Ativo","Lido","Não Lido","Importante","Pendente","Arquivado"})
     *     ),
     *     @OA\Parameter(
     *         name="pagina",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Itens por página",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function memorandosParticipados(MemorandoBuscarTodosValidation $request) : JsonResponse
    {
        try {
            $dto = MemorandoBuscarTodosDTO::fromArray($request->validated());

            $dto->id_pessoa = $request->user()->id_pessoa;

            $memorandos = $this->memorandoService->memorandosParticipados($dto);

            return $this->sucessoResponse(new PaginacaoResource($memorandos, MemorandoEntradaResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/memorando/{id}",
     *     summary="Buscar um memorando pelo id",
     *     tags={"Memorando"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do memorando",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação realizada com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function buscarPorId(int $id) : JsonResponse
    {
        try {
            $with = ['despachos.anexos', 'despachos.remetente', 'despachos.destinatario'];
            $memorando = $this->memorandoService->buscarPorId($id, $with);

            return $this->sucessoResponse( new MemorandoResource($memorando) );
        } catch (\Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/memorando",
     *     summary="Cadastra um memorando",
     *     tags={"Memorando"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/MemorandoCadastrarValidation")
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Memorando cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(MemorandoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();
            $anexos = $request->file('anexos') ?? [];

            $memorandoData = [
                'titulo'    => $validated['titulo'],
                'id_pessoa' => $request->user()->id_pessoa,
            ];

            $despachoData = [
                'texto'            => $validated['texto'],
                'id_destinatario' => $validated['id_destinatario'],
                'id_remetente'     => $request->user()->id_pessoa,
            ];

            $memorandoDTO = MemorandoCadastrarDTO::fromArray($memorandoData);
            $despachoDTO = DespachoCadastrarDTO::fromArray($despachoData);

            $memorandoCriado = $this->memorandoService->criarTudo($memorandoDTO, $despachoDTO, $anexos);

            return $this->sucessoResponse($memorandoCriado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/memorando/{id}",
     *     summary="Atualizar um memorando",
     *     tags={"Memorando"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id do Memorando",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MemorandoAtualizarValidation")
     *     ),
     *     @OA\Response(
     *         response=204,
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
    public function atualizar(int $id, MemorandoAtualizarValidation $request) : JsonResponse
    {
        try {
            $memorandoDTO = MemorandoAtualizarDTO::fromArray($request->validated());

            $memorandoAtualizado = $this->memorandoService->atualizarComAutorizacao($id, $request->user()->id_pessoa, $memorandoDTO);

            return $this->sucessoResponse($memorandoAtualizado);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
