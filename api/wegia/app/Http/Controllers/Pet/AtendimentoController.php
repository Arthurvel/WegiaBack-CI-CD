<?php

namespace App\Http\Controllers\Pet;

use App\DTOs\Pet\AtualizarAtendimentoDTO;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\PetService;
use App\Validations\Pet\AtualizarAtendimentoValidation;
use App\Validations\Pet\BuscarAtendimentoValidation;
use App\Validations\Pet\CriarAtendimentoValidation;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations\Get;

class AtendimentoController extends BaseController
{
    protected $petService;

    public function __construct(
        PetService $petService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->petService = $petService;
    }

    /**
     * @OA\Post(
     *     path="/pet/ficha-medica/{id_ficha_medica}/atendimento",
     *     summary="Cadastrar o Atendimento",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_ficha_medica",
     *         in="path",
     *         description="ID da Ficha Medica",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"data_atendimento", "descricao"},
     *             @OA\Property(property="data_atendimento", type="string", format="date", description="Data do Atendimento"),
     *             @OA\Property(property="descricao", type="string", description="Descricao")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(int $id_ficha_medica, Request $request):JsonResponse
    {
        try{ 
            $this->validarRequest(
                [   
                    ...$request->all(),
                    'id_ficha_medica' => $id_ficha_medica
                ],
                CriarAtendimentoValidation::rules(),
                CriarAtendimentoValidation::messages()
            );
            $criarAtendimento=$this->petService->criarAtendimento($request->all(), $id_ficha_medica);
            return $this->sucessoResponse($criarAtendimento, 201);
        }catch(Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());

        }
    }
    
    /**
     * @OA\Delete(
     *     path="/pet/ficha-medica/atendimento/{id_atendimento}",
     *     summary="Deletar o Atendimento",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_atendimento",
     *         in="path",
     *         description="ID do Atendimento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function delete(int $id_atendimento):JsonResponse
    {
        try{ 
            $deletarAtendimento=$this->petService->deletarAtendimento($id_atendimento);
            return $this->sucessoResponse($deletarAtendimento,200);
        }catch(Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());

        }
    }
     /**
     * @OA\Put(
     *     path="/pet/ficha-medica/atendimento/{id_atendimento}",
     *     summary="Atualizar um atendimento",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_atendimento",
     *         in="path",
     *         description="ID do Atendimento",
     *         @OA\Schema(type="integer")
     *     ),
     *        @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="data_atendimento", type="string", format="date", description="Data do Atendimento"),
     *             @OA\Property(property="descricao", type="string", description="Descricao")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Atendimento atualizado com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function update(Request $request, int $id_atendimento) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    ...$request->all(),  
                    'id_atendimento' => $id_atendimento  
                ],
                AtualizarAtendimentoValidation::rules(),
                AtualizarAtendimentoValidation::messages()
            );

            $resultado = $this->petService->atualizarAtendimento($request->all(), $id_atendimento);

            return $this->sucessoResponse($resultado);
            
        } catch (Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());
        } 
    }
    /**
     * @OA\Get(
     *     path="/pet/ficha-medica/{id_ficha_medica}/atendimento",
     *     summary="Buscar o atendimento do Pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id_ficha_medica",
     *         in="path",
     *         description="ID da Ficha Medica do Pet",
     *         @OA\Schema(type="integer")
     *     ),
     *       @OA\Parameter(
     *         name="buscar",
     *         in="query",
     *         description="Campo para buscar(data_atendimento, descricao)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ordenacao",
     *         in="query",
     *         description="Campo para ordenar (data_atendimento, descricao)",
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
     *         description="Quantidade de atendimentos por página",
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
}