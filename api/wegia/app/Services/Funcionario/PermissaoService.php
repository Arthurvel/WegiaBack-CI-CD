<?php

namespace App\Services\Funcionario;

use App\Repositories\Funcionario\PermissaoRepository;
use App\Services\Base\BaseService;

/**
 * @extends BaseService
 */
class PermissaoService extends BaseService
{
  public function __construct(PermissaoRepository $repository)
  {
      parent::__construct($repository);
  }
}