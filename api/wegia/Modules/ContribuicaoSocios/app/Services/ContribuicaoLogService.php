<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\Enums\SelecaoParagrafoEnum;
use App\Helpers\UploadSeguroHelper;
use app\Repositories\Configuracao\CampoImagemRepository;
use app\Repositories\Configuracao\SelecaoParagrafoRepository;
use app\Repositories\Configuracao\TabelaImagemCampoRepository;
use App\Services\Base\BaseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarTodosParamsDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarComprovantePagamentoPorPeriodoDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoLogCadastrarDTO;
use Modules\ContribuicaoSocios\app\Mail\GerarComprovanteMail;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoLogRepository;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoRecorrenciaRepository;

class ContribuicaoLogService extends BaseService
{

    private ContribuicaoRecorrenciaRepository $recorrenciaRepository;
    private SelecaoParagrafoRepository $paragrafoRepository;
    private CampoImagemRepository $campoImagemRepository;

    public function __construct
    (
        ContribuicaoLogRepository $repository,
        ContribuicaoRecorrenciaRepository $recorrenciaRepository,
        SelecaoParagrafoRepository $paragrafoRepository,
        CampoImagemRepository $campoImagemRepository
    )
    {
        parent::__construct($repository);
        $this->recorrenciaRepository = $recorrenciaRepository;
        $this->paragrafoRepository = $paragrafoRepository;
        $this->campoImagemRepository = $campoImagemRepository;
    }


    public function buscarTodasPaginado(ContribuicaoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodasPaginado($dto);
    }

    public function atualizarPagamento(object $data)
    {
        if($data->subscription) {
            DB::transaction(function () use ($data) {

                $recorrencia = $this->recorrenciaRepository->buscarPorCodigo($data->subscription->id);

                $contribuicaoLogCadastrarDTO = ContribuicaoLogCadastrarDTO::fromArray([
                    'id_socio'          => $recorrencia->id_socio,
                    'id_gateway'        => $recorrencia->id,
                    'id_meio_pagamento' => 5,
                    'id_recorrencia'    => $recorrencia->id,
                    'codigo'            => null,
                    'valor'             => $recorrencia->valor,
                    'data_geracao'      => now()->format('Y-m-d'),
                    'data_vencimento'   => now()->format('Y-m-d'),
                    'data_pagamento'    => now()->format('Y-m-d'),
                    'status_pagamento'  => true,

                ]);

                return $this->repository->criar($contribuicaoLogCadastrarDTO);

            });
        } else {
            return $this->repository->atualizarPagamento($data->id);
        }
    }

    public function buscarContribuicoesSegundaVia(string $documento)
    {
        return $this->repository->buscarContribuicoesSegundaVia($documento);
    }

    public function gerarComprovantePorEmail(ContribuicaoBuscarComprovantePagamentoPorPeriodoDTO $dto)
    {
        $comprovante = $this->repository->buscarComprovantePagamentoPorPeriodo($dto);

        if ($comprovante->isEmpty()) {
            abort(404, 'Não existe comprovante para o período informado.');
        }

        if($comprovante[0]->socio->email === '') {
            abort(404, 'Email não foi cadastrado.');
        }

        $email  = $comprovante[0]->socio->email;
        $nome   = $comprovante[0]->socio->pessoa->nome;
        $codigo = bin2hex(random_bytes(8));
        $soma   = number_format($comprovante->sum(fn ($item) => (float) $item->valor), 2, ',', '.');

        $logo                  = $this->campoImagemRepository->buscarPorNomeCampo('logo');
        $cnpjInstituicao       = $this->paragrafoRepository->buscarPorNome(SelecaoParagrafoEnum::CNPJ);
        $mensagemAgradecimento = $this->paragrafoRepository->buscarPorNome(SelecaoParagrafoEnum::AGRADECIMENTO_DOADOR);

        $logoPath = $logo['imagens'][0]['imagem'] ?? null;
        $logoBase64 = null;

        if ($logoPath) {
            $logoBase64 = UploadSeguroHelper::imagemSeguraParaBase64($logoPath);
        }

        if (!$logoBase64) {
            $logoBase64 = UploadSeguroHelper::imagemPublicaParaBase64('wegia.png');
        }

        $pdf = Pdf::loadView('contribuicaosocios::components.gerar-comprovante', [
            'comprovante'           => $comprovante,
            'logoBase64'            => $logoBase64,
            'cnpjInstituicao'       => $cnpjInstituicao,
            'mensagemAgradecimento' => $mensagemAgradecimento,
            'codigo'                => $codigo,
            'nome'                  => $nome,
            'email'                 => $email,
            'soma'                  => $soma
        ]);


        UploadSeguroHelper::salvarPdf($pdf->output(), 'contribuicao/comprovante', $codigo);

        $pdfConteudo = $pdf->output();

        Mail::to($email)
            ->send(new GerarComprovanteMail(
                $nome,
                $soma,
                $dto->data_inicio,
                $dto->data_fim,
                $pdfConteudo
            ));
    }

}
