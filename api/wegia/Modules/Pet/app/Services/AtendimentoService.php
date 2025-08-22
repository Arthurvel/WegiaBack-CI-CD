<?php

namespace Modules\Pet\app\Services;

use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Pet\app\DTO\AtendimentoBuscarTodosDTO;
use Modules\Pet\app\DTO\AtendimentoComMedicamentoDTO;
use Modules\Pet\app\DTO\AtendimentoDTO;
use Modules\Pet\app\DTO\MedicacaoDTO;
use Modules\Pet\app\Repositories\AtendimentoRepository;
use Modules\Pet\app\Repositories\MedicacaoRepository;

class AtendimentoService extends BaseService
{

    private MedicacaoRepository $medicacaoRepository;
    public function __construct
    (
        AtendimentoRepository $repository,
        MedicacaoRepository $medicacaoRepository
    )
    {
        parent::__construct($repository);
        $this->medicacaoRepository = $medicacaoRepository;
    }

    public function buscarTodosPaginado(AtendimentoBuscarTodosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

    public function criarComMedicamento(AtendimentoComMedicamentoDTO $dto)
    {
        return DB::Transaction(function () use ($dto) {

            $medicamentos = $dto->medicamentos ?? [];
            unset($dto->medicamentos);

            $atendimentoDTO = AtendimentoDTO::fromArray($dto->toArray());
            $atendimento = $this->repository->criar($atendimentoDTO);

            if (!empty($medicamentos)) {
                $medicacoesDTO = array_map(function ($medicamento) use ($atendimento, $atendimentoDTO) {
                    return MedicacaoDTO::fromArray([
                        'id_medicamento'      => $medicamento,
                        'id_pet_atendimento' => $atendimento->id_pet_atendimento,
                        'data_medicacao'     => $atendimentoDTO->data_atendimento
                    ]);
                }, (array) $medicamentos);

                $this->medicacaoRepository->criarEmMassa($medicacoesDTO);
            }

            return $atendimento;
        });
    }

}
