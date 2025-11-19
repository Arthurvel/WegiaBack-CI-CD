<?php

namespace app\Services\Funcionario;

use app\DTOs\Funcionario\Documento\FuncionarioDocumentoBuscarDTO;
use app\DTOs\Funcionario\Documento\FuncionarioDocumentoCadastrarComUrlDTO;
use app\DTOs\Funcionario\Documento\FuncionarioDocumentoCadastrarDTO;
use app\DTOs\Funcionario\Documento\FuncionarioDocumentoTipoCadastrarDTO;
use App\Helpers\UploadSeguroHelper;
use app\Repositories\Funcionario\FuncionarioDocumentoRepository;
use App\Services\Base\BaseService;

class FuncionarioDocumentoService extends BaseService
{

    public function __construct(
        FuncionarioDocumentoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function cadastrarDocumento(FuncionarioDocumentoCadastrarDTO $dto)
    {
        $url = UploadSeguroHelper::salvarImagem($dto->arquivo, 'funcionario/documentos');

        $documentoDTO = FuncionarioDocumentoCadastrarComUrlDTO::fromArray([
            'id_funcionario' => $dto->id_funcionario,
            'id_docfuncional' => $dto->id_docfuncional,
            'arquivo' => $url,
            'extensao_arquivo' => $dto->arquivo->getClientOriginalName(),
            'nome_arquivo' => $dto->arquivo->getClientOriginalName(),
        ]);

        return $this->repository->criar($documentoDTO);
    }

    public function pegarDocumentos(FuncionarioDocumentoBuscarDTO $dto)
    {
        return $this->repository->pegarDocumentos($dto);
    }

    public function buscarDocumentoTipo()
    {
        return $this->repository->buscarDocumentoTipo();
    }

    public function cadastrarDocumentoTipo(FuncionarioDocumentoTipoCadastrarDTO $dto)
    {
        return $this->repository->cadastrarDocumentoTipo($dto);
    }
}
