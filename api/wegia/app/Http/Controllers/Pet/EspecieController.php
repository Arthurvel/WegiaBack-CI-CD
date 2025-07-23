<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Especie;
use App\Services\PetService;
use App\Validations\Pet\CriarEspecieValidation;
use Exception;
use Illuminate\Http\JsonResponse;

class EspecieController extends BaseController
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
    *     path="/pet/especie",
    *     summary="Cadastrar as Espécies",
    *     tags={"Pet"},
    *     security={{"bearerAuth": {}}},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"descricao"},
    *             @OA\Property(property="descricao", type="string", description="Campo descrição")
    *         )
    *     ),
    *     @OA\Response(response="200", description="Operação realizada com sucesso!", @OA\JsonContent()),
    *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
    *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
    * )
    */
    public function create(Request $request):JsonResponse
    {
        try{
            $this->validarRequest(
                $request->all(),
                CriarEspecieValidation::rules(),
                CriarEspecieValidation::messages()
            );
            $criarEspecie=$this->petService->criarEspecie($request->all());
            return $this->sucessoResponse($criarEspecie,201);
        }catch(Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/pet/especie",
     *     summary="Buscar os todas as especies",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function index() : JsonResponse
    {
        try {
                $especie = $this->petService->pegarEspecie();
                    return  $this->sucessoResponse($especie);
            } catch (Exception $e) {
                    return $this->errorResponse($e);
        }
    }
}