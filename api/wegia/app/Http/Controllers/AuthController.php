<?php

namespace App\Http\Controllers;

use App\Services\PessoaService;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Operações relacionadas a autenticação"
 * )
 */
class AuthController extends BaseController
{

    protected $pessoaService;
    protected $authService;

    public function __construct(PessoaService $pessoaService, AuthService $authService)
    {
        $this->middleware('auth:sanctum')->except('login');

        $this->pessoaService = $pessoaService;
        $this->authService = $authService;
    }


    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Realizar login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf", "senha"},
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="senha", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário e token retornados com sucesso",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Usuário não autorizado (login ou senha invalidos)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="message", example="CPF ou senha incorretos"),
     *             @OA\Property(property="data", type="data", example=null)
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro no servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="message", example="Mensagem de erro"),
     *             @OA\Property(property="data", type="data", example=null)
     *         ),
     *     ),
     * )
     */
    public function login(Request $request) : JsonResponse
    {

        try {
            $request->validate([
                'cpf' => 'required|string',
                'senha' => 'required|string',
            ]);

            $pessoa = $this->pessoaService->buscarPessoaPorCpfSemFormatacao($request->cpf);

            if ($pessoa && $pessoa->validarSenha($request->senha)) {    
            
                return $this->sucessoResponse([
                    'pessoa' => $pessoa,
                    'token' => $this->authService->gerarToken($pessoa)
                ]);
            }

            return $this->errorResponse(null, 401, 'CPF ou senha incorretos');
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
                
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Realizar logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token revogado com sucesso",
     *     ),
     *     @OA\Header(
     *         header="Accept",
     *         description="Define o tipo de conteúdo aceito",
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     * 
     *     @OA\Response(
     *         response=401,
     *         description="Usuário não autorizado (token invalido)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="message", example="Token inválido"),
     *             @OA\Property(property="data", type="data", example=null)
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro no servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="message", example="Mensagem de erro"),
     *             @OA\Property(property="data", type="data", example=null)
     *         ),
     *     ),
     * )
     */
    public function logout(Request $request) 
    {
        try {
            $revogado = $this->authService->revogarToken($request->user());            

            return $this->sucessoResponse($revogado);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
