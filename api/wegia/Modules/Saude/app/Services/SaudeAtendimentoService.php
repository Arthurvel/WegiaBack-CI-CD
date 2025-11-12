<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Saude\app\DTO\SaudeAtendimentoBuscarTodosParamsDTO;
use Modules\Saude\app\DTO\SaudeAtendimentoCadastrarDTO;
use Modules\Saude\app\DTO\SaudeAtendimentoComMedicacaoCadastrarDTO;
use Modules\Saude\app\DTO\SaudeMedicacaoCadastrarDTO;
use Modules\Saude\app\Repositories\SaudeAtendimentoRepository;
use Modules\Saude\app\Repositories\SaudeMedicacaoRepository;

class SaudeAtendimentoService extends BaseService
{

    public SaudeMedicacaoRepository $repositorySaudeMedicacao;

    public function __construct
    (
        SaudeAtendimentoRepository $repository,
        SaudeMedicacaoRepository $repositorySaudeMedicacao
    )
    {
        parent::__construct($repository);
        $this->repositorySaudeMedicacao = $repositorySaudeMedicacao;
    }

    public function criarComMedicacao(SaudeAtendimentoComMedicacaoCadastrarDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $atendimentoDTO = SaudeAtendimentoCadastrarDTO::fromArray($dto->toArray());

            $atendimento = $this->repository->criar($atendimentoDTO);

            if(!empty($dto->medicacoes)) {
                $medicacoesParaInserir = [];

                foreach ($dto->medicacoes as $m) {
                    $medicacoesParaInserir[] = SaudeMedicacaoCadastrarDTO::fromArray([
                        'id_atendimento' => $atendimento->id_atendimento,
                        'medicamento'    => $m['medicamento'],
                        'dosagem'        => $m['dosagem'],
                        'horario'        => $m['horario'],
                        'duracao'        => $m['duracao'],
                    ])->toArray();
                }
                $atendimento->medicacoes()->createMany($medicacoesParaInserir);
            }

            return $atendimento;
        });
    }

    public function buscarTodosPaginado(SaudeAtendimentoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }
}
