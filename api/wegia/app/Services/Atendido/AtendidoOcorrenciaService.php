<?php

namespace app\Services\Atendido;

use app\DTOs\Atendido\AtendidoOcorrenciaBuscarDTO;
use App\DTOs\Atendido\AtendidoOcorrenciaCadastrarDTO;
use app\DTOs\Atendido\AtendidoOcorrenciaComFotoCadastrarDTO;
use App\DTOs\Atendido\AtendidoOcorrenciaDocCadastrarDTO;
use App\Helpers\UploadSeguroHelper;
use app\Repositories\Atendido\AtendidoOcorrenciaDocRepository;
use app\Repositories\Atendido\AtendidoOcorrenciaRepository;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class AtendidoOcorrenciaService extends BaseService
{

    private AtendidoOcorrenciaDocRepository $atendidoOcorrenciaDocRepository;

    public function __construct(
        AtendidoOcorrenciaRepository $repository,
        AtendidoOcorrenciaDocRepository $atendidoOcorrenciaDocRepository
    )
    {
        parent::__construct($repository);
        $this->atendidoOcorrenciaDocRepository = $atendidoOcorrenciaDocRepository;
    }

    public function buscarOcorrencias(AtendidoOcorrenciaBuscarDTO $dto)
    {
        return $this->repository->buscarOcorrencias($dto);
    }

    public function cadastrarOcorrencia(AtendidoOcorrenciaComFotoCadastrarDTO $dto)
    {
        DB::beginTransaction();

        try {
            $ocorrenciaDTO = AtendidoOcorrenciaCadastrarDTO::fromArray($dto->toArray());
            $ocorrencia = $this->repository->criar($ocorrenciaDTO);

            if($dto->arquivo) {
                $url = UploadSeguroHelper::salvarImagem($dto->arquivo, 'atendido/ocorrencias');
                $nomeOriginal = $dto->arquivo->getClientOriginalName();
                $extensao = $dto->arquivo->getClientOriginalExtension();

                $docDTO = AtendidoOcorrenciaDocCadastrarDTO::fromArray([
                    'arquivo_nome'                              => $nomeOriginal,
                    'arquivo_extensao'                          => $extensao,
                    'arquivo'                                    => $url,
                    'atentido_ocorrencia_idatentido_ocorrencias' => $ocorrencia->idatendido_ocorrencias,
                    'data'                                       => $dto->data
                ]);

                $this->atendidoOcorrenciaDocRepository->criar($docDTO);
            }

            DB::commit();
            return $ocorrencia;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function buscarOcorrenciaTipos()
    {
        return $this->repository->buscarOcorrenciaTipos();
    }
}
