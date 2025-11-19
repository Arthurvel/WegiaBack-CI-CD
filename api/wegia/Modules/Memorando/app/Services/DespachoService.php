<?php

namespace Modules\Memorando\app\Services;

use App\Helpers\UploadSeguroHelper;
use App\Services\Base\BaseService;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Memorando\app\DTO\AnexoCadastrarDTO;
use Modules\Memorando\app\DTO\DespachoCadastrarDTO;
use Modules\Memorando\app\Repositories\AnexoRepository;
use Modules\Memorando\app\Repositories\DespachoRepository;
use Modules\Memorando\app\Repositories\MemorandoRepository;

class DespachoService extends BaseService
{
    private AnexoRepository $anexoRepository;
    private MemorandoRepository $memorandoRepository;

    public function __construct
    (
        DespachoRepository $repository,
        MemorandoRepository $memorandoRepository,
        AnexoRepository $anexoRepository,
    )
    {
        parent::__construct($repository);
        $this->anexoRepository = $anexoRepository;
        $this->memorandoRepository = $memorandoRepository;
    }

    public function criarComAnexos(DespachoCadastrarDTO $despachoDTO, int $id_pessoa, array $anexos)
    {
        $ultimoDestinatario = $this->repository->ultimoDestinatario($despachoDTO->id_memorando);

        if($ultimoDestinatario['id_destinatario'] != $id_pessoa){
            throw new AuthorizationException("Você não tem permissão para cadastrar este despacho.");
        }

        if($ultimoDestinatario['memorando']['status_memorando'] == "Arquivado"){
            throw new AuthorizationException('Você não tem permissão para cadastrar em um memorando arquivado.');
        }

        $despacho = $this->repository->criar($despachoDTO);

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

        $despacho->load('anexos');

        return $despacho;
    }

}
