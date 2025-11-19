<?php

namespace Modules\Memorando\app\Services;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use App\Services\Base\BaseService;
use App\Helpers\UploadSeguroHelper;
use Modules\Memorando\app\DTO\AnexoCadastrarDTO;
use Modules\Memorando\app\DTO\DespachoCadastrarDTO;
use Modules\Memorando\app\DTO\MemorandoAtualizarDTO;
use Modules\Memorando\app\DTO\MemorandoBuscarTodosDTO;
use Modules\Memorando\app\DTO\MemorandoCadastrarDTO;
use Modules\Memorando\app\Repositories\AnexoRepository;
use Modules\Memorando\app\Repositories\DespachoRepository;
use Modules\Memorando\app\Repositories\MemorandoRepository;

class MemorandoService extends BaseService
{
    private DespachoRepository $despachoRepository;
    private AnexoRepository $anexoRepository;
    public function __construct
    (
        MemorandoRepository $repository,
        DespachoRepository $despachoRepository,
        AnexoRepository $anexoRepository
    )
    {
        parent::__construct($repository);
        $this->despachoRepository = $despachoRepository;
        $this->anexoRepository = $anexoRepository;
    }

    public function buscarTodosFiltro(MemorandoBuscarTodosDTO $dto)
    {
        return $this->repository->buscarTodosFiltro($dto);
    }

    public function memorandosParticipados(MemorandoBuscarTodosDTO $dto)
    {
        $ids = $this->despachoRepository->buscarIdsQueUsuarioParticipou($dto->id_pessoa);

        return $this->repository->memorandosParticipados($dto, $ids);
    }


    public function criarTudo(MemorandoCadastrarDTO $memorandoDTO, DespachoCadastrarDTO $despachoDTO, array $anexos = null)
    {
        return DB::transaction(function () use ($memorandoDTO, $despachoDTO, $anexos) {
            $memorando = $this->repository->criar($memorandoDTO);

            $despachoDTO->id_memorando = $memorando->id_memorando;

            $despacho = $this->despachoRepository->criar($despachoDTO);

            if(!is_null($anexos)) {
                foreach ($anexos as $arquivo) {
                    $url = UploadSeguroHelper::salvarImagem($arquivo, 'memorando');

                    $anexoCadastrarDto = AnexoCadastrarDTO::fromArray([
                        "id_despacho" => $despacho->id_despacho,
                        "anexo"       => $url,
                        "extensao"    => $arquivo->extension(),
                        "nome"        => $arquivo->getClientOriginalName()
                    ]);

                    $this->anexoRepository->criar($anexoCadastrarDto);
                }
            }

            $memorando->load('despachos.anexos');

            return $memorando;
        });
    }

    public function atualizarComAutorizacao(int $id, int $id_pessoa, MemorandoAtualizarDTO $dto)
    {
        $ultimoDestinatario = $this->despachoRepository->ultimoDestinatario($id);
        $memorando = $ultimoDestinatario['memorando'];

        if ($ultimoDestinatario['id_destinatario'] !== $id_pessoa) {
            throw new AuthorizationException('Você não tem permissão para atualizar este memorando.');
        }

        return parent::atualizar($id, $dto);
    }
}
