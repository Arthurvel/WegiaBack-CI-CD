<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\BaseController;
use App\Models\Pet\FichaMedica;
use Illuminate\Http\Request;
use App\Services\PetService;
use App\Validations\Pet\AtualizarFichaMedicaValidation;
use App\Validations\Pet\CriarFichaMedicaValidation;
use Exception;
use Illuminate\Http\JsonResponse;

class FichaMedicaController extends BaseController
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
     *     path="/pet/{id_pet}/ficha-medica",
     *     summary="Cadastrar a Ficha Medica",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_pet",
     *         in="path",
     *         description="ID do Pet",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"castrado", "necessidades_especiais"},
     *             @OA\Property(property="castrado", type="string", description="Castrado"),
     *             @OA\Property(property="necessidades_especiais", type="string", description="Necessidades Especiais")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(int $id_pet, Request $request):JsonResponse
    {
        try{ 
            $this->validarRequest(
                [   
                    ...$request->all(),
                    'id_pet' => $id_pet
                ],
                CriarFichaMedicaValidation::rules(),
                CriarFichaMedicaValidation::messages()
            );
            $criarFichaMedica=$this->petService->criarFichaMedica($request->all(), $id_pet);
            return $this->sucessoResponse($criarFichaMedica,201);
        }catch(Exception $e) {
            return $this->errorResponse(null, 500, $e->getMessage());

        }
    }
    /**
     * @OA\Put(
     *     path="/pet/ficha-medica/{id_ficha_medica}",
     *     summary="Atualizar uma ficha médica de um pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_ficha_medica",
     *         in="path",
     *         description="ID da Ficha Medica",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="castrado", type="string", description="Castrado(s,n)"),
     *              @OA\Property(property="necessidades_especiais", type="string", description="Necessidades Especiais"),
     *          )    
     *      ),
     *     @OA\Response(response="200", description="Ficha Medica atualizada com sucesso", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function update(Request $request, int $id_ficha_medica) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    ...$request->all(),  
                    'id_ficha_medica' => $id_ficha_medica  
                ],
                AtualizarFichaMedicaValidation::rules(),
                AtualizarFichaMedicaValidation::messages()
            );

            $resultado = $this->petService->atualizarFichaMedica($request->all(), $id_ficha_medica);

            return $this->sucessoResponse($resultado);
            
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }
    /**
     * @OA\Get(
     *     path="/pet/{id_pet}/ficha-medica",
     *     summary="Buscar a ficha medica do Pet",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id_pet",
     *         in="path",
     *         description="ID do Pet",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index(int $id_pet) : JsonResponse
    {   
        try {
            $ficha_medica = $this->petService->pegarFichaMedicaPorPet($id_pet);
            return  $this->sucessoResponse($ficha_medica);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        } 
    }
}