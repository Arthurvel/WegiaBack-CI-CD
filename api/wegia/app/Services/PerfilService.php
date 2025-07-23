<?php

namespace App\Services;

use App\Repositories\PerfilRepository;
use App\Services\Base\BaseService;
use App\DTOs\Funcionario\Perfil\CadastrarPerfilDTO;
use App\DTOs\Funcionario\Perfil\AtualizarPerfilDTO;
use App\DTOs\Funcionario\Perfil\SincronizarPermissaoDTO;

/**
 * @extends BaseService<CadastrarPerfilDTO, AtualizarPerfilDTO>
 */
class PerfilService extends BaseService
{
  public function __construct(PerfilRepository $repository)
  {
      parent::__construct($repository);
  }

  public function cadastrarPermissao(int $id, SincronizarPermissaoDTO $dto)
  {
    return $this->repository->sincronizarPermissao($id, $dto);
  }

  public function buscarPorIdComPermissoes(int $id)
  {
    return $this->repository->buscarPorIdComPermissoes($id);
  }

}