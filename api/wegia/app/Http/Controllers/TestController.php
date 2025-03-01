<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Pessoa;

/**
 * @OA\Tag(
 *     name="Teste",
 *     description="Operações relacionadas a teste"
 * )
 */
class TestController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/teste",
     *     summary="Lista todos os teste",
     *     tags={"Teste"},
     *     @OA\Response(response="200", description="Lista de teste"),
     *     @OA\Response(response="500", description="Erro interno")
     * )
     */
    public function index()
    {
        try {
            $pessoa =  Pessoa::findOrFail(2);
            return $this->sucessoResponse($pessoa);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
        
    }

}