<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\PetService;
use App\Validations\Pet\CriarRacaValidation;
use Exception;
use Illuminate\Http\JsonResponse;

class RacaController extends BaseController
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
     *     path="/pet/raca",
     *     summary="Cadastrar as racas",
     *     tags={"Pet"},
     *     security={{"bearerAuth": {}}},
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"descricao"},
     *             @OA\Property(property="descricao", type="string", description="Campo descrição"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="OpeRacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function create(Request $request):JsonResponse
    {
        try{ 
            $this->validarRequest(
                $request->all(),
                CriarRacaValidation::rules(),
                CriarRacaValidation::messages()
            );
            $criarRaca=$this->petService->criarRaca($request->all());
            return $this->sucessoResponse($criarRaca,201);
        }catch(Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/pet/raca",
     *     summary="Buscar os todas as Racas",
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
                $Raca = $this->petService->pegarRaca();
                    return  $this->sucessoResponse($Raca);
            } catch (Exception $e) {
                    return $this->errorResponse($e);
        } 
    }
}