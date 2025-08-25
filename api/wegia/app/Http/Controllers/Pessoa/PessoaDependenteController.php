<?php

namespace App\Http\Controllers\Pessoa;

use app\DTOs\Pessoa\Dependente\PessoaDependenteBuscarTodosPorIdDTO;
use app\DTOs\Pessoa\Dependente\PessoaDependenteCadastrarDTO;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Paginacao\PaginacaoResource;
use App\Http\Resources\Pessoa\PessoaDependenteResource;
use app\Services\Pessoa\PessoaDependenteService;
use app\Validations\Pessoa\Dependente\PessoaDependenteBuscarTodosValidation;
use App\Validations\Pessoa\Dependente\PessoaDependenteCadastrarValidation;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Pessoa",
 *     description="Operações relacionadas as pessoas"
 * )
 */
class PessoaDependenteController extends BaseController
{
    private PessoaDependenteService $service;

    public function __construct(
        PessoaDependenteService $service
    )
    {
        $this->middleware(['auth:sanctum', 'ability:criar-dependente'])->only(['create']);
        $this->middleware(['auth:sanctum', 'ability:visualizar-dependente'])->only(['buscarDependentesPorIdPessoa']);
        $this->middleware(['auth:sanctum', 'ability:deletar-dependente'])->only(['destroy']);
        $this->middleware('auth:sanctum')->except([]);

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/pessoa/{id_pessoa}/dependente",
     *     summary="Buscar dependentes de uma pessoa",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="id_pessoa",
     *          in="path",
     *          description="Id da pessoa",
     *          required=false,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Nome e tipo de dependencia para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="with",
     *         in="query",
     *         description="Nome e tipo de dependencia para busca",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (Nome e parentesco)",
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
    public function buscarDependentesPorIdPessoa(int $id_pessoa, PessoaDependenteBuscarTodosValidation $request) : JsonResponse
    {
        try {
            $validated = $request->validated();

            $dto = PessoaDependenteBuscarTodosPorIdDTO::fromArray([
                $id_pessoa => $id_pessoa,
                ...$validated
            ]);

            $pessoa = $this->service->buscarDependentesPorIdPessoa($id_pessoa, $dto);

            return $this->sucessoResponse(new PaginacaoResource($pessoa, PessoaDependenteResource::class));
        } catch (\Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/pessoa/{id_pessoa}/dependente/{id_dependente}",
     *     summary="Cadastrar um novo dependente",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_pessoa",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id_dependente",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/PessoaDependenteCadastrarValidation")
     *     ),
     *     @OA\Response(response="201", description="Cadastro realizado com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function create(int $id_pessoa, int $id_dependente, PessoaDependenteCadastrarValidation $request) : JsonResponse
    {

        try {
            $validated = $request->validated();

            $dto = PessoaDependenteCadastrarDTO::fromArray([
               'id_pessoa' => $id_pessoa,
               'id_dependente_pessoa' => $id_dependente,
               'parentesco' => $validated["parentesco"]
            ]);

            $pessoa = $this->service->criarDependente($dto);

            return $this->sucessoResponse($pessoa, 201, 'Cadastro realizado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }

    }

    /**
     * @OA\Delete(
     *     path="/pessoa/dependente/{id_dependente}",
     *     summary="Deletar um dependente",
     *     tags={"Pessoa"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_dependente",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Cadastro realizado com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function destroy(int $id_dependente) : JsonResponse
    {
        try {
            $pessoa = $this->service->deletar($id_dependente);

            return $this->sucessoResponse(true, 204, 'Deletado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }

}
