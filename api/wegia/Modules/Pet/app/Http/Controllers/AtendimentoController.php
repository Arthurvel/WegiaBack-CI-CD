<?php

namespace Modules\Pet\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Pet\app\DTO\AtendimentoBuscarTodosDTO;
use Modules\Pet\app\DTO\AtendimentoComMedicamentoDTO;
use Modules\Pet\app\Http\Resources\AtendimentoResource;
use Modules\Pet\app\Services\AtendimentoService;
use Modules\Pet\app\Validations\AtendimentoBuscarTodosValidation;
use Modules\Pet\app\Validations\AtendimentoCadastrarValidation;

class AtendimentoController extends BaseController
{

    private AtendimentoService $atendimentoService;

    public function __construct(
        AtendimentoService $atendimentoService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-atendimento'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-atendimento'])->only(['index']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->atendimentoService = $atendimentoService;
    }

    /**
     * @OA\Get(
     *     path="/pet/ficha-medica/{id}/atendimento",
     *     summary="Buscar todos os atendimentos de uma ficha medica",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da Ficha Medica",
     *           required=true,
     *           @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo de ordenação (data_atendimento)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"data_atendimento"})
     *     ),
     *     @OA\Parameter(
     *         name="tipoOrdenacao",
     *         in="query",
     *         description="Tipo de ordenação ASC ou DESC",
     *         required=false,
     *         @OA\Schema(type="string", enum={"ASC","asc","DESC","desc"})
     *     ),
     *     @OA\Parameter(
     *         name="pagina",
     *         in="query",
     *         description="Número da página (mínimo 1)",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Quantidade de itens por página (mínimo 1)",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Erro de validação",
     *          @OA\JsonContent()
     *      )
     *  )
     */
    public function index(int $id, AtendimentoBuscarTodosValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $data = [
                'id_ficha_medica' => $id,
                ...$validated
            ];

            $atendimento = $this->atendimentoService->buscarTodosPaginado(new AtendimentoBuscarTodosDTO($data));

            return $this->sucessoResponse( new PaginacaoResource($atendimento, AtendimentoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/pet/ficha-medica/{id}/atendimento",
     *     summary="Cadastra um atendimento na ficha medica do pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da Ficha Medica",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AtendimentoCadastrarValidation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Atendimento cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(int $id_ficha_medica, AtendimentoCadastrarValidation $request)
    {
        try {
            $validated = $request->validated();

            $data = [
                'id_ficha_medica' => $id_ficha_medica,
                ...$validated
            ];

            $dto = AtendimentoComMedicamentoDTO::fromArray($data);

            $criado = $this->atendimentoService->criarComMedicamento($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
