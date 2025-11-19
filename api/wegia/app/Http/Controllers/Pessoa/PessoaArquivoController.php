<?php

namespace app\Http\Controllers\Pessoa;

use app\DTOs\Pessoa\Arquivo\PessoaArquivoBuscarPaginadoDTO;
use app\DTOs\Pessoa\Arquivo\PessoaArquivoComFileCadastrarDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use app\Http\Resources\Pessoa\PessoaArquivoResource;
use app\Services\Pessoa\PessoaArquivoService;
use app\Validations\Pessoa\Arquivo\PessoaArquivoBuscarPaginadoValidation;
use app\Validations\Pessoa\Arquivo\PessoaArquivoCadastrarValidation;
use Illuminate\Http\JsonResponse;

class PessoaArquivoController extends BaseController
{

    private PessoaArquivoService $service;
    public function __construct(
        PessoaArquivoService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-arquivo-para-pessoa'])->only(['cadastrar']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-arquivo-da-pessoa'])->only(['index']);
        $this->middleware(['auth:sanctum', 'ability:deletar-arquivo-da-pessoa'])->only(['deletar']);
        $this->middleware(['auth:sanctum'])->except(['']);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/pessoa/{id}/arquivo",
     *     summary="Buscar arquivos de uma pessoa",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID da Pessoa",
     *           required=true,
     *           @OA\Schema(type="integer")
     *     ),
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
     *         description="Campo de ordenação (data, descricao)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"data","descricao"})
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
    public function index(int $id, PessoaArquivoBuscarPaginadoValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = PessoaArquivoBuscarPaginadoDTO::fromArray([
                ...$validated,
                'id_pessoa' => $id
            ]);

            $arquivos = $this->service->buscarTodosPaginados($dto);

            return $this->sucessoResponse(new PaginacaoResource($arquivos, PessoaArquivoResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/pessoa/{id}/arquivo",
     *     summary="Cadastra um arquivo",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da Pessoa",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/PessoaArquivoCadastrarValidation")
     *          )
     *     ),
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
    public function cadastrar(int $id, PessoaArquivoCadastrarValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();
            $arquivo = $request->file('arquivo') ?? null;

            $dto = PessoaArquivoComFileCadastrarDTO::fromArray([
                'arquivo' => $arquivo,
                'pessoa_id' => $id,
                ...$validated
            ]);

            $criado = $this->service->cadastrarArquivo($dto);

            return $this->sucessoResponse($criado, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/pessoa/arquivo/{id}",
     *     summary="Exclui um arquivo de uma pessoa",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do arquivo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="true", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function deletar(int $id)
    {
        try {
            $this->service->deletar($id);

            return $this->sucessoResponse(true, 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
