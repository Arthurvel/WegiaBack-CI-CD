<?php

namespace Modules\Saude\app\Services;

use App\Helpers\UploadSeguroHelper;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Saude\app\DTO\SaudeExameBuscarParamsDTO;
use Modules\Saude\app\DTO\SaudeExameCadastrarDTO;
use Modules\Saude\app\DTO\SaudeExameComFotoCadastrarDTO;
use Modules\Saude\app\Repositories\SaudeExameRepository;

class SaudeExameService extends BaseService
{

    public function __construct
    (
        SaudeExameRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(SaudeExameBuscarParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }


    public function criarComFoto(SaudeExameCadastrarDTO $dto)
    {
        return DB::Transaction(function () use ($dto) {

            $url = UploadSeguroHelper::salvarImagem($dto->arquivo, 'saude');
            $nomeArquivo = $dto->arquivo->getClientOriginalName();
            $nomeArquivo = substr($nomeArquivo, 0, 255);

            $fotoCadastrarDto = SaudeExameComFotoCadastrarDTO::fromArray([
                'id_fichamedica'   => $dto->id_fichamedica,
                'id_exame_tipo'    => $dto->id_exame_tipo,
                'data'             => $dto->data,
                'arquivo_nome'     => $nomeArquivo,
                'arquivo_extensao' => $dto->arquivo->extension(),
                'arquivo'          => $url,
            ]);

            return $this->repository->criar($fotoCadastrarDto);
        });
    }

    public function deletarComFoto(int $id) : void
    {
        $exame = $this->buscarPorId($id);

        $deletado = UploadSeguroHelper::excluirImagem($exame->arquivo);

        if (!$deletado) {
            throw new \Exception("Erro ao excluir o arquivo: {$exame->arquivo_nome}");
        }

        $this->repository->deletar($id);
    }

}
