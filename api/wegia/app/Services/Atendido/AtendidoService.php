<?php

namespace app\Services\Atendido;

use app\DTOs\Atendido\AtendidoBuscarDTO;
use App\DTOs\Atendido\AtendidoDTO;
use App\DTOs\Atendido\AtendidoOcorrenciaDTO;
use App\DTOs\Atendido\AtendidoOcorrenciaDocCadastrarDTO;
use App\DTOs\Atendido\AtendidoOcorrenciaCadastrarDTO;
use App\DTOs\PaginacaoDTO;
use App\Helpers\UploadSeguroHelper;
use App\Models\Atendido\Atendido;
use app\Repositories\Atendido\AtendidoRepository;
use App\Services\Base\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AtendidoService extends BaseService
{

    protected $atendimentoRepository;

    public function __construct(
        AtendidoRepository $atendimentoRepository,
        AtendidoRepository $repository
    )
    {
        parent::__construct($repository);
        $this->atendimentoRepository = $atendimentoRepository;
    }

    public function buscarAtendimentos(AtendidoBuscarDTO $dto)
    {
        return $this->atendimentoRepository->buscarAtendimentos($dto);
    }

}
