<?php

namespace App\Http\Controllers\Funcionario;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\DTOs\Perfil\CadastrarPerfilDTO;
use App\Services\PerfilService;
use App\Validations\Funcionario\BuscarRemuneracaoPorFuncionarioValidation;
use App\Validations\Perfil\CadastrarPerfilValidation;


class PerfilController extends BaseController
{

    protected $perfilService;

    public function __construct(
        PerfilService $perfilService
    )
    {
        $this->middleware('auth:sanctum')->except([]);

        $this->perfilService = $perfilService;
    }

    /**
     * @OA\Get(
     *     path="/funcionario/perfil",
     *     summary="Cadastra um perfil",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="cargo",
     *          in="query",
     *          description="Nome do cargo",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="acao",
     *         in="query",
     *         description="nome",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function cadastrarPerfil(Request $request) : JsonResponse
    {
        try {
            $this->validarRequest(
                [
                    ...$request->all()
                ],
                CadastrarPerfilValidation::rules(),
                CadastrarPerfilValidation::messages()
            );

            $dto = CadastrarPerfilDTO::fromArray($request->all());

            $perfil = $this->perfilService->cadastrarPerfil($dto);

            return $this->sucessoResponse($perfil, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
