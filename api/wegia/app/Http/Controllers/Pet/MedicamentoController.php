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
use App\Validations\Pet\CriarMedicamentoValidation;
use Exception;
use Illuminate\Http\JsonResponse;

class MedicamentoController extends BaseController
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
     *     path="/pet/ficha-medica/atendimento/medicacao/medicamento",
     *     summary="Cadastrar o Medicamento",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome_medicamento", "descricao_medicamento", "aplicacao"},
     *             @OA\Property(property="nome_medicamento", type="string", description="Nome do Medicamento"),
     *             @OA\Property(property="descricao_medicamento", type="string", description="Descricao do Medicamento"),
     *             @OA\Property(property="aplicacao", type="string", description="Aplicacao do Medimento")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request):JsonResponse
    {
        try{ 
            $this->validarRequest(
                [   
                    ...$request->all(),
                ],
                CriarMedicamentoValidation::rules(),
                CriarMedicamentoValidation::messages()
            );
            $criarMedicamento=$this->petService->criarMedicamento($request->all());
            return $this->sucessoResponse($criarMedicamento,201);
        }catch(Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());

        }
    }
         /**
     * @OA\Delete(
     *     path="/pet/ficha-medica/atendimento/medicacao/medicamento/{id_medicamento}",
     *     summary="Deletar o Medicamento",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_medicamento",
     *         in="path",
     *         description="ID do Medicamento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function delete(int $id_medicamento):JsonResponse
    {
        try{ 
            $deletarMedicamento=$this->petService->deletarMedicamento($id_medicamento);
            return $this->sucessoResponse($deletarMedicamento,200);
        }catch(Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());

        }
    }
/**
     * @OA\Get(
     *     path="/pet/ficha-medica/atendimento/medicacao/medicamento",
     *     summary="Buscar os todos os Medicamentos",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="OpeRacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index() : JsonResponse
    {   
        try {
                $Medicamento = $this->petService->pegarMedicamento();
                    return  $this->sucessoResponse($Medicamento);
            } catch (Exception $e) {
                    return $this->errorResponse($e);
        } 
    }
 }