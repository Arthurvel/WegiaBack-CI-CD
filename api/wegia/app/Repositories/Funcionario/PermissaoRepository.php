<?php

namespace App\Repositories\Funcionario;

use App\Models\Funcionario\Perfil\FuncionarioPermissao;
use App\Repositories\Base\BaseRepository;

/**
 * @extends BaseRepository<FuncionarioPermissao>
 * @extends BaseService<>
 */
class PermissaoRepository extends BaseRepository
{
    public function __construct(
      FuncionarioPermissao $model
    )
    {
        parent::__construct($model);
    }

}
