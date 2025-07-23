<?php

namespace App\Repositories;

use App\Models\Funcionario\Perfil\FuncionarioPerfil;
use App\Repositories\Base\BaseRepository;
use App\DTOs\Funcionario\Perfil\CadastrarPerfilDTO;
use App\DTOs\Funcionario\Perfil\AtualizarPerfilDTO;
use App\DTOs\Funcionario\Perfil\SincronizarPermissaoDTO;

/**
 * @extends BaseRepository<Perfil>
 * @extends BaseService<CadastrarPerfilDTO, AtualizarPerfilDTO>
 */
class PerfilRepository extends BaseRepository
{
    public function __construct(
      FuncionarioPerfil $model
    )
    {
        parent::__construct($model);
    }

    public function sincronizarPermissao(int $id, SincronizarPermissaoDTO $dto)
    {
      $perfil = $this->buscarPorId($id);

      $perfil->permissoes()->sync($dto->permissoes);

      return $perfil;
    }

    public function buscarPorIdComPermissoes(int $id)
    {
        return $this->model->with('permissoes')->findOrFail($id);
    }

}
