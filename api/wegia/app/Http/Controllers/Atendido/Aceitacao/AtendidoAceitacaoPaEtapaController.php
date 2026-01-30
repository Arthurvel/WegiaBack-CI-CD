<?php

namespace app\Http\Controllers\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaAtualizarDTO;
use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaBuscarTodosDTO;
use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaCadastrarDTO;
use App\Http\Controllers\BaseController;
use app\Http\Resources\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaResource;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Services\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaService;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaAtualizarValidation;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaBuscarTodosValidation;
use app\Validations\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaCadastrarValidation;

class AtendidoAceitacaoPaEtapaController extends BaseController
{

    protected AtendidoAceitacaoPaEtapaService $service;

    public function __construct(
        AtendidoAceitacaoPaEtapaService $service
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/atendido/aceitacao/{id_processo}/etapa",
     *     summary="Buscar todos as etapas de um processo de aceitação paginados",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *             name="id_processo",
     *             in="path",
     *             description="Id do processo",
     *             required=true,
     *             @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          required=false,
     *          description="Status da etapa de aceitação",
     *          @OA\Schema(type="string")
     *     ),
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
    public function buscarTodos(AtendidoAceitacaoPaEtapaBuscarTodosValidation $request, int $id_processo)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoAceitacaoPaEtapaBuscarTodosDTO::fromArray([
                'id_processo' => $id_processo,
                ...$validated
            ]);

            $etapas = $this->service->buscarTodosPaginado($dto);

            return  $this->sucessoResponse( new PaginacaoResource($etapas, AtendidoAceitacaoPaEtapaResource::class)  );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\Post(
     *     path="/atendido/aceitacao/{id_processo}/etapa",
     *     summary="Cadastra uma pessoa no processo de aceitação",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *            name="id_processo",
     *            in="path",
     *            description="Id da aceitacao",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AtendidoAceitacaoPaEtapaCadastrarValidation")
     *     ),
     *     @OA\Response(response="201", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function cadastrar(AtendidoAceitacaoPaEtapaCadastrarValidation $request, int $id_processo)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoAceitacaoPaEtapaCadastrarDTO::fromArray([
                ...$validated,
                'id_processo' => $id_processo,
            ]);

            $this->service->criar($dto);

            return  $this->sucessoResponse( null, 201 );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/atendido/aceitacao/etapa/{id_etapa}",
     *     summary="Atualizar uma etapa",
     *     tags={"Atendido"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/AtendidoAceitacaoPaEtapaAtualizarValidation")
     *     ),
     *     @OA\Parameter(
     *            name="id_etapa",
     *            in="path",
     *            description="Id da etapa",
     *            required=true,
     *            @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function atualizar(AtendidoAceitacaoPaEtapaAtualizarValidation $request, int $id_etapa)
    {
        try {
            $validated = $request->validated();

            $dto = AtendidoAceitacaoPaEtapaAtualizarDTO::fromArray($validated);

            $this->service->atualizar($id_etapa, $dto);

            return  $this->sucessoResponse( null, 201 );
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
