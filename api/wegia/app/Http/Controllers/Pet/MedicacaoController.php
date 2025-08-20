<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\BaseController;
use App\Models\Pet\FichaMedica;
use Illuminate\Http\Request;
use App\Services\PetService;
use App\Validations\Pet\AtualizarFichaMedicaValidation;
use App\Validations\Pet\BuscarMedicacaoValidation;
use App\Validations\Pet\CriarFichaMedicaValidation;
use App\Validations\Pet\CriarMedicacaoValidation;
use Exception;
use Illuminate\Http\JsonResponse;

class MedicacaoController extends BaseController
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
     *     path="/pet/ficha-medica/atendimento/{id_pet_atendimento}/medicacao",
     *     summary="Cadastrar a Medicacao",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_pet_atendimento",
     *         in="path",
     *         description="ID da Medicacao",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_medicamento", "data_medicacao"},
     *             @OA\Property(property="id_medicamento", type="integer", description="Id do Medicamento"),
     *             @OA\Property(property="data_medicacao", type="string", format="date", description="Data da Medicacao")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(int $id_pet_atendimento, Request $request):JsonResponse
    {
        try{ 
            $this->validarRequest(
                [   
                    ...$request->all(),
                    'id_pet_atendimento' => $id_pet_atendimento
                ],
                CriarMedicacaoValidation::rules(),
                CriarMedicacaoValidation::messages()
            );
            $criarMedicacao=$this->petService->criarMedicacao($request->all(), $id_pet_atendimento);
            return $this->sucessoResponse($criarMedicacao,201);
        }catch(Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());

        }
    }
     /**
     * @OA\Delete(
     *     path="/pet/ficha-medica/atendimento/medicacao/{id_medicacao}",
     *     summary="Deletar a Medicacao",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_medicacao",
     *         in="path",
     *         description="ID da Medicacao",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function delete(int $id_medicacao):JsonResponse
    {
        try{ 
            $deletarMedicacao=$this->petService->deletarMedicacao($id_medicacao);
            return $this->sucessoResponse($deletarMedicacao,200);
        }catch(Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());

        }
    }
    /**
     * @OA\Get(
     *     path="/pet/ficha-medica/atendimento/{id_pet_atendimento}/medicacao",
     *     summary="Buscar a Medicacao por Atendimento",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id_pet_atendimento",
     *         in="path",
     *         description="ID do Atendimento do Pet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="itensPorPagina",
     *         in="query",
     *         description="Quantidade de medicamentos por página",
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
    public function index(int $id_pet_atendimento, Request $request) : JsonResponse
    {   
        try {
            $this->validarRequest(
                [   
                    ...$request->query(),
                    'id_pet_atendimento' => $id_pet_atendimento
                ],
                BuscarMedicacaoValidation::rules(),
                BuscarMedicacaoValidation::messages()
            );
            $medicacao = $this->petService->pegarMedicacaoPorAtendimento($id_pet_atendimento, $request->query());
            return  $this->sucessoResponse($medicacao);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }
}