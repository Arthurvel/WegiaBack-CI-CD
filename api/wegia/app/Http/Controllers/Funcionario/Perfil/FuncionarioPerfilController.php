<?php

namespace App\Http\Controllers\Funcionario\Perfil;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Funcionario\PerfilResource;
use App\Services\PerfilService;
use App\DTOs\Funcionario\Perfil\CadastrarPerfilDTO;
use App\DTOs\Funcionario\Perfil\AtualizarPerfilDTO;
use App\DTOs\Funcionario\Perfil\SincronizarPermissaoDTO;
use App\Validations\Funcionario\Perfil\CadastrarFuncionarioPerfilValidation;
use App\Validations\Funcionario\Perfil\AtualizarFuncionarioPerfilValidation;
use App\Validations\Funcionario\Perfil\SincronizarFuncionarioPerfilPermissaoValidation;


class FuncionarioPerfilController extends BaseController
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
     * @OA\POST(
     *     path="/funcionario/perfil",
     *     summary="Cadastra um perfil",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CadastrarFuncionarioPerfilValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function cadastrarPerfil(CadastrarFuncionarioPerfilValidation $request) : JsonResponse
    {
        try {
            $dto = CadastrarPerfilDTO::fromArray($request->validated());

            $perfil = $this->perfilService->criar($dto);

            return $this->sucessoResponse($perfil, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/perfil",
     *     summary="Buscar um perfil",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarPerfis() : JsonResponse
    {
        try {
            $perfis = $this->perfilService->buscarTodos();

            return $this->sucessoResponse($perfis);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/funcionario/perfil/{id}/permissao",
     *     summary="Buscar as permissoes de um perfil",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do perfil",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function buscarPermissoesDoPerfil(int $id) : JsonResponse
    {
        try {
            $perfil = $this->perfilService->buscarPorIdComPermissoes($id);
            $resource = new PerfilResource($perfil);

            return $this->sucessoResponse($resource);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/funcionario/perfil/{id}/permissao",
     *     summary="Buscar um perfil",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do perfil",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SincronizarFuncionarioPerfilPermissaoValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function cadastrarPermissao(int $id, SincronizarFuncionarioPerfilPermissaoValidation $request) : JsonResponse
    {
        try {
            $dto = SincronizarPermissaoDTO::fromArray($request->validated());
            $perfis = $this->perfilService->cadastrarPermissao($id, $dto);

            return $this->sucessoResponse($perfis);
        } catch (Exception $e) {
            return $this->errorResponse(null,500,$e->getMessage());
        }
    }

    /**
     * @OA\Put(
     *     path="/funcionario/perfil/{id}",
     *     summary="Buscar um perfil",
     *     tags={"Funcionario"},
     *     security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do perfil",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AtualizarFuncionarioPerfilValidation")
     *     ),
     *     @OA\Response(response="200", description="Operacao realizada com sucesso!", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Erro de validação", @OA\JsonContent()),
     *     @OA\Response(response="500", description="Erro interno", @OA\JsonContent())
     * )
    */
    public function atualizarPerfil(int $id, AtualizarFuncionarioPerfilValidation $request) : JsonResponse
    {
        try {
            $dto = AtualizarPerfilDTO::fromArray($request->validated());
            $perfis = $this->perfilService->atualizar($id, $dto);

            return $this->sucessoResponse($perfis);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
