<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeFichaMedicaProntuarioHistoricoCadastrarDTO;
use Modules\Saude\app\Repositories\SaudeFichaMedicaProntuarioHistoricoRepository;
use Modules\Saude\app\Repositories\SaudeFichaMedicaRepository;

class SaudeFichaMedicaProntuarioHistoricoService extends BaseService
{

    private SaudeFichaMedicaRepository $saudeFichaMedicaRepository;

    public function __construct
    (
        SaudeFichaMedicaProntuarioHistoricoRepository $repository,
        SaudeFichaMedicaRepository $saudeFichaMedicaRepository
    )
    {
        parent::__construct($repository);

        $this->saudeFichaMedicaRepository = $saudeFichaMedicaRepository;
    }

    public function criarHistorico(int $id_ficha_medica)
    {
        $ficha_medica = $this->saudeFichaMedicaRepository->buscarPorId($id_ficha_medica);

        $dto = SaudeFichaMedicaProntuarioHistoricoCadastrarDTO::fromArray([
            'id_fichamedica' => $id_ficha_medica,
            'prontuario'     => $ficha_medica->prontuario,
        ]);

        return $this->repository->criar($dto);
    }


}
