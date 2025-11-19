<?php

namespace Modules\Pet\app\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use Illuminate\Http\JsonResponse;
use Modules\Pet\app\DTO\PetAtualizarComFoto;
use Modules\Pet\app\DTO\PetBuscarTodosDTO;
use Modules\Pet\app\DTO\PetCadastrarComFotoDto;
use Modules\Pet\app\Http\Resources\PetResource;
use Modules\Pet\app\Services\PetService;
use Modules\Pet\app\Validations\PetAtualizarValidation;
use Modules\Pet\app\Validations\PetBuscarTodosValidation;
use Modules\Pet\app\Validations\PetCadastrarValidation;

/**
 * @OA\Tag(
 *     name="Pet",
 *     description="Operações relacionadas ao Modulo de Pet"
 * )
 */
class PetController extends BaseController
{

    private PetService $petService;

    public function __construct(
        PetService $petService
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-pet'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-pet'])->only(['index', 'buscarPorId']);
        $this->middleware(['auth:sanctum', 'ability:deletar-pet'])->only(['excluir']);
        $this->middleware(['auth:sanctum', 'ability:atualizar-pet'])->only(['atualizar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->petService = $petService;
    }

    /**
     * @OA\Get(
     *     path="/pet",
     *     summary="Buscar todos os pets",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Texto para busca por nome",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo de ordenação (nome, cor, sexo, data_nascimento, data_acolhimento)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"nome","cor","sexo","data_nascimento","data_acolhimento"})
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
    public function index(PetBuscarTodosValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();
            $pets = $this->petService->buscarTodosPaginado(new PetBuscarTodosDTO($validated));

            return $this->sucessoResponse( new PaginacaoResource($pets, PetResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\get(
     *     path="/pet/{id}",
     *     summary="Buscar um pet pelo id",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Pet",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="true", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function buscarPorId(int $id) : JsonResponse
    {
        try {
            $with = ['especie', 'raca', 'foto', 'fichaMedica', 'adocao.pessoa'];
            $pet = $this->petService->buscarPorId($id, $with);

            return $this->sucessoResponse(new PetResource($pet));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/pet",
     *     summary="Cadastra um pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/PetCadastrarValidation")
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pet cadastrado com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function cadastrar(PetCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();
            $foto = $request->file('foto') ?? null;

            $petData = [
                'foto'            => $foto,
                ...$validated
            ];

            $petDto = PetCadastrarComFotoDto::fromArray($petData);

            $petCriado = $this->petService->criarComFoto($petDto);

            return $this->sucessoResponse($petCriado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\post(
     *     path="/pet/{id}",
     *     summary="Editar um pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Pet",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/PetAtualizarValidation")
     *           )
     *      ),
     *     @OA\Response(response="204", description="true", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function atualizar(int $id, PetAtualizarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();
            $foto = $request->file('foto') ?? null;

            $petData = [
                'foto'  => $foto,
                ...$validated
            ];

            $dto = PetAtualizarComFoto::fromArray($petData);

            $this->petService->atualizarComFoto($id, $dto);

            return $this->sucessoResponse(true, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * @OA\Delete(
     *     path="/pet/{id}",
     *     summary="Exclui um pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Pet",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="true", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function excluir(int $id) : JsonResponse
    {
        try {
           $this->petService->deletar($id);

            return $this->sucessoResponse(true, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

}
