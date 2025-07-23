<?php

namespace App\Http\Controllers\Funcionario\Perfil;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\DTOs\Perfil\CadastrarPerfilDTO;
use App\DTOs\Perfil\AtualizarPerfilDTO;
use App\Services\Funcionario\PermissaoService;
use App\Validations\Funcionario\Perfil\CadastrarFuncionarioPerfilValidation;
use App\Validations\Funcionario\Perfil\AtualizarFuncionarioPerfilValidation;


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

}
