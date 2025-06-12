<?php

namespace App\Http\Controllers\Pessoa;

use App\Http\Controllers\BaseController;
use App\Services\PessoaService;
use App\Validations\Pessoa\Dependente\CriarPessoaDependenteValidation;
use App\Validations\Pessoa\Dependente\DependenteExisteValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Pessoa",
 *     description="Operações relacionadas as pessoas"
 * )
 */
class PessoaDependenteController extends BaseController
{
    private $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->pessoaService = $pessoaService;
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
    public function buscarDependentesPorIdPessoa(int $id_pessoa, Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                [ 
                    "id_pessoa" => $id_pessoa,
                    ...$request->all()
                ],
                CriarPessoaDependenteValidation::rules($id_pessoa),
                CriarPessoaDependenteValidation::messages()
            );

            $pessoa = $this->pessoaService->buscarDependentesPorIdPessoa($id_pessoa, $request->all());
            
            return $this->sucessoResponse($pessoa);
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
     *         required=true,
     *         @OA\JsonContent(
     *             required={"parentesco"},
     *             @OA\Property(
     *                 property="parentesco",
     *                 type="string",
     *                 description="Tipo de parentesco",
     *                 enum={
     *                     "Companheiro(a)",
     *                     "Cônjuge",
     *                     "Enteado(a)",
     *                     "Ex-cônjuge",
     *                     "Filho(a)",
     *                     "Irmão(ã)",
     *                     "Neto(a)",
     *                     "Pais",
     *                     "Outra relação de dependência"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Cadastro realizado com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
     */
    public function create(int $id_pessoa, int $id_dependente, Request $request) : JsonResponse
    {

        try {
            $this->validarRequest(
                [ 
                    "id_pessoa" => $id_pessoa,
                    "id_dependente_pessoa" => $id_dependente,
                    ...$request->all()
                ],
                CriarPessoaDependenteValidation::rules($id_pessoa),
                CriarPessoaDependenteValidation::messages()
            );

            $pessoa = $this->pessoaService->criarParentesco($request->all(), $id_pessoa, $id_dependente);
            
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
            $this->validarRequest(
                [ 
                    "id_dependente" => $id_dependente,
                ],
                DependenteExisteValidation::rules(),
                DependenteExisteValidation::messages()
            );
            
            $pessoa = $this->pessoaService->deletarDependente($id_dependente);
            
            return $this->sucessoResponse($pessoa, 200, 'Deletado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }

}