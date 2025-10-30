<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\Repositories\TransacaoProdutoRepository;

class TransacaoProdutoService extends BaseService
{

    public function __construct
    (
        TransacaoProdutoRepository $repository
    )
    {
        parent::__construct($repository);
    }
}
