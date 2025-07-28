<?php

namespace App\Http\Controllers\Funcionario\Perfil;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\Services\Funcionario\PermissaoService;


class FuncionarioPermissaoController extends BaseController
{

    protected $permissaoService;

    public function __construct(
      PermissaoService $permissaoService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->permissaoService = $permissaoService;
    }

    /**
     * @OA\Get(
     *     path="/funcionario/permissao",
     *     summary="Buscar todas as permissoes",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarPermissao() : JsonResponse
    {
        try {
            $data = $this->permissaoService->buscarTodos();

            return $this->sucessoResponse($data);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
