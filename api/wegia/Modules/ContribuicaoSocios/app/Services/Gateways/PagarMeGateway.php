<?php

namespace Modules\ContribuicaoSocios\app\Services\Gateways;

use App\DTOs\Pessoa\PessoaDTO;
use App\Helpers\UploadSeguroHelper;
use App\Models\Pessoa\Pessoa;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Modules\ContribuicaoSocios\app\DTO\PagamentoCadastrarDTO;
use Modules\ContribuicaoSocios\app\DTO\PagamentoGatewayDTO;
use Modules\ContribuicaoSocios\app\Interfaces\PagamentoGatewayInterface;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoLogRepository;
use Modules\ContribuicaoSocios\app\Repositories\SocioRepository;
use Modules\ContribuicaoSocios\app\Traits\GerarCodigoTrait;
use Nette\Utils\DateTime;
use setasign\Fpdi\Fpdi;

class PagarMeGateway implements PagamentoGatewayInterface
{

    use GerarCodigoTrait;

    private string $url = "https://api.pagar.me/core/v5";
    private SocioRepository $socioRepository;
    private ContribuicaoLogRepository $contribuicaoLogRepository;

    public function __construct(
        protected string $secretKey,
    )
    {
        $this->socioRepository = app(SocioRepository::class);
        $this->contribuicaoLogRepository = app(ContribuicaoLogRepository::class);
    }

    public function criarPix(PagamentoCadastrarDTO $dto, int $id_gateway): PagamentoGatewayDTO
    {
        $socio = $this->socioRepository->buscarPorId($dto->id_socio);
        $pessoa = $socio->pessoa;

        $codigo = $this->gerarCodigo();
        $vencimento = now()->addDay()->format('Y-m-d');

        $data = $this->basePayload($dto, $pessoa, $socio->email, $codigo);

        $this->addTelefone($data, $pessoa);
        $this->addPagamentoPix($data, $dto);

        try {
            $responseData = $this->chamada($data);

            return PagamentoGatewayDTO::fromArray([
                'url' => $responseData['charges'][0]['last_transaction']['qr_code'],
                'imagem' => $responseData['charges'][0]['last_transaction']['qr_code_url'],
                'id_pedido' => $responseData['id'],
                'vencimento' => $vencimento,
                'metodo' => 'pix'
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function criarBoleto(PagamentoCadastrarDTO $dto, int $id_gateway): PagamentoGatewayDTO
    {
        $socio = $this->socioRepository->buscarPorId($dto->id_socio);
        $pessoa = $socio->pessoa;

        $codigo = $this->gerarNumeroDocumento(16);
        $vencimento = now()->addDays(7)->format('Y-m-d');
        $data = $this->basePayload($dto, $pessoa, $socio->email, $codigo);

        $this->addCustomerAddress($data, $pessoa);
        $this->addPagamentoBoleto($data, $codigo, $vencimento);

        try {
            $responseData = $this->chamada($data);

            $url = $this->salvarImagem($responseData['charges'][0]['last_transaction']['pdf']);

            return PagamentoGatewayDTO::fromArray([
                'url' => '',
                'imagem' => $responseData['charges'][0]['last_transaction']['pdf'],
                'id_pedido' => $responseData['id'],
                'vencimento' => $vencimento,
                'metodo' => 'boleto',
                'url_privada' => $url
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    /**
     * @return PagamentoGatewayDTO[]
     */
    public function criarCarne(PagamentoCadastrarDTO $dto, int $id_gateway): array
    {
        $socio = $this->socioRepository->buscarPorId($dto->id_socio);
        $pessoa = $socio->pessoa;

        $codigo = $this->gerarCodigo();

        $dataAtual = new DateTime();
        $pagamentoGatewayArrayDTO = [];
        $pdfUrls = [];

        if ($dto->data_vencimento <= $dataAtual->format('d')) {
            $dataAtual->modify('first day of next month');
        }

        for ($i = 0; $i < $dto->parcelas; $i++) {
            $data = $this->basePayload($dto, $pessoa, $socio->email, $codigo);

            $this->addCustomerAddress($data, $pessoa);

            $dataVencimento = clone $dataAtual;

            $dataVencimento->modify("+{$i} month");

            $dataVencimento->setDate($dataVencimento->format('Y'), $dataVencimento->format('m'), $dto->data_vencimento);

            if ($dataVencimento->format('d') != $dto->data_vencimento) {
                $dataVencimento->modify('last day of previous month');
            }

            $numeroDocumento = $this->gerarNumeroDocumento(16);

            $this->addPagamentoCarne($data, $numeroDocumento, $dataVencimento);


            try {
                $responseData = $this->chamada($data);
                $pdfUrl = $responseData['charges'][0]['last_transaction']['pdf'];

                $pdfUrls[] = $pdfUrl;

                $pagamentoGatewayArrayDTO[] = PagamentoGatewayDTO::fromArray([
                    'url' => '',
                    'imagem' => $pdfUrl,
                    'id_pedido' => $responseData['id'],
                    'vencimento' => $dataVencimento,
                    'metodo' => 'carne'
                ]);

            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }

        $pdfUnificado = $this->juntarPDFs($pdfUrls);

        $caminhoCarneCompleto = $this->salvarPdf($pdfUnificado, 'carne_completo');

        foreach ($pagamentoGatewayArrayDTO as &$pagamentoDTO) {
            $pagamentoDTO->url_privada = $caminhoCarneCompleto;
        }
        unset($pagamentoDTO);

        return $pagamentoGatewayArrayDTO;
    }

    public function criarCartaoCredito(PagamentoCadastrarDTO $dto, int $id_gateway): PagamentoGatewayDTO
    {
        $socio = $this->socioRepository->buscarPorId($dto->id_socio);
        $pessoa = $socio->pessoa;

        $codigo = $this->gerarCodigo();
        $data = $this->basePayload($dto, $pessoa, $socio->email, $codigo);

        $this->addCustomerAddress($data, $pessoa);
        $this->addTelefone($data, $pessoa);
        $this->addPagamentoCartao($data, $pessoa, $dto->cartao_hash);

        try {
            $responseData = $this->chamada($data);

            if ($responseData['status'] != 'failed') {
                return PagamentoGatewayDTO::fromArray([
                    'url' => '',
                    'imagem' => '',
                    'id_pedido' => $responseData['id'],
                    'vencimento' => now()->format('Y-m-d'),
                    'metodo' => 'Cartao de Credito',
                    'url_privada' => ''
                ]);
            } else {
                throw new \Exception($responseData['message']);
            }

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function criarCartaoCreditoRecorrencia(PagamentoCadastrarDTO $dto, int $id_gateway): PagamentoGatewayDTO
    {
        $socio = $this->socioRepository->buscarPorId($dto->id_socio);
        $pessoa = $socio->pessoa;

        $codigo = $this->gerarCodigo();
        $data = $this->basePayload($dto, $pessoa, $socio->email, $codigo);

        $this->addTelefone($data, $pessoa);
        $this->addPagamentoCartaoRecorrente($data, $pessoa, $dto);

        try {
            $responseData = $this->chamada($data, '/subscriptions');

            return PagamentoGatewayDTO::fromArray([
                'url' => '',
                'imagem' => '',
                'id_pedido' => $responseData['id'],
                'vencimento' => now()->format('Y-m-d'),
                'metodo' => 'Cartao de Credito Recorrente',
                'url_privada' => ''
            ]);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function basePayload(PagamentoCadastrarDTO $dto, Pessoa $pessoa, string $email, string $codigo)
    {
        $cpfSemMascara = preg_replace('/\D/', '', $pessoa->cpf);
        $description = "Contribuição Sócio - $pessoa->nome $pessoa->sobrenome";

        return [
            'items' => [
                [
                    'amount' => intval($dto->valor * 100),
                    'description' => $description,
                    'quantity' => 1,
                    "code" => $codigo
                ]
            ],
            "customer" => [
                "name" => $pessoa->nome,
                "email" => $email,
                "document_type" => "CPF",
                "document" => $cpfSemMascara,
                "type" => "Individual"
            ],
        ];

    }

    private function chamada($data, $complemento = '/orders')
    {
        $ch = curl_init($this->url . $complemento);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($this->secretKey . ":")
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception("Erro ao criar: " . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode >= 400) {
            $message = $responseData['message'] ?? 'Erro desconhecido';

            $detalhes = [];

            if (isset($responseData['errors']) && is_array($responseData['errors'])) {
                foreach ($responseData['errors'] as $campo => $errosCampo) {
                    foreach ($errosCampo as $erro) {
                        $detalhes[] = "{$campo}: {$erro}";
                    }
                }
            }

            if (!empty($detalhes)) {
                $message .= " | Detalhes: " . implode(" | ", $detalhes);
            }

            throw new \Exception("Erro ao criar: {$message}");
        }

        return $responseData;
    }

    private function addTelefone(array &$data, Pessoa $pessoa)
    {
        $telefone = preg_replace('/\D/', '', $pessoa->telefone);

        $data["customer"]["phones"] = [
            "mobile_phone" => [
                "country_code" => "55",
                "area_code" => substr($telefone, 0, 2),
                "number" => substr($telefone, 2),
            ]
        ];
    }

    private function addPagamentoPix(array &$data, PagamentoCadastrarDTO $dto)
    {
        $data["payments"] = [
            [
                "payment_method" => "pix",
                "pix" => [
                    "expires_in" => 3600,
                    "additional_information" => [
                        [
                            "name" => "Doação via pix",
                            "value" => $dto->valor
                        ]
                    ]
                ]
            ]
        ];
    }

    private function addCustomerAddress(array &$data, Pessoa $pessoa)
    {
        $data["customer"]["address"] = [
            "line_1" => $pessoa->logradouro . ", n°" . $pessoa->numero_endereco . ", " . $pessoa->bairro,
            "line_2" => $pessoa->complemento,
            "zip_code" => $pessoa->cep,
            "city" => $pessoa->cidade,
            "state" => $pessoa->estado,
            "country" => "BR"
        ];
    }

    private function addPagamentoBoleto(array &$data, string $codigo, string $vencimento)
    {
        $data['payments'] = [
            [
                "payment_method" => "boleto",
                "boleto" => [
                    "instructions" => 'Instruções de responsabilidade do BENEFICIÁRIO. Qualquer dúvida sobre este boleto contate o beneficiário',
                    "document_number" => $codigo,
                    "due_at" => $vencimento,
                    "type" => "DM"
                ]
            ]
        ];
    }

    private function addPagamentoCarne(array &$data, string $numeroDocumento, string $vencimento)
    {
        $data['payments'] = [
            [
                "payment_method" => "boleto",
                "boleto" => [
                    "instructions" => 'Instruções de responsabilidade do BENEFICIÁRIO. Qualquer dúvida sobre este Carne contate o beneficiário',
                    "document_number" => $numeroDocumento,
                    "due_at" => $vencimento,
                    "type" => 'DM'
                ]
            ]
        ];
    }

    private function addPagamentoCartao(array &$data, Pessoa $pessoa, string $cartao_hash, $qtd_parcelas = 1)
    {

        $data["payments"] = [
            [
                "payment_method" => "credit_card",
                "credit_card" => [
                    "card_token" => $cartao_hash,
                    "installments" => $qtd_parcelas,
                    "statement_descriptor" => "doacao",
                    "card" => [
                        "billing_address" => [
                            "line_1" => $pessoa->logradouro . ", n°" . $pessoa->numero_endereco . ", " . $pessoa->bairro,
                            "zip_code" => $pessoa->cep,
                            "city" => $pessoa->cidade,
                            "state" => $pessoa->estado,
                            "country" => "BR"
                        ]
                    ]

                ]
            ]
        ];
    }

    private function addPagamentoCartaoRecorrente(array &$data, Pessoa $pessoa, PagamentoCadastrarDTO $dto)
    {
        $valorEmCentavos = intval($dto->valor * 100);

        $data['items'] = [
            [
                "description"    => "Plano Contribuicao Mensal",
                "quantity"       => 1,
                "amount"         => $valorEmCentavos,  // ← ADICIONE ISSO!
                "pricing_scheme" => [
                    "scheme_type" => "unit",
                    "price"       => $valorEmCentavos
                ]
            ]
        ];

        $data["payment_method"] = "credit_card";
        $data["card_token"] = $dto->cartao_hash;
        $data["billing_type"] = "prepaid";
        $data["installments"] = 1;
        $data["statement_descriptor"] = "Contribuicao Mensal";

        $data["billing_address"] = [
            "line_1"   => $pessoa->logradouro . ", n°" . $pessoa->numero_endereco . ", " . $pessoa->bairro,
            "zip_code" => $pessoa->cep,
            "city"     => $pessoa->cidade,
            "state"    => $pessoa->estado,
            "country"  => "BR"
        ];

        $data["pricing_scheme"] = [
            "scheme_type" => "unit",
            "price"       => $valorEmCentavos
        ];

        $data["interval"] = "month";
        $data["interval_count"] = 1;
        $data["minimum_price"] = $valorEmCentavos;
    }

    private function salvarPdf(string $content, string $nomeArquivo): string
    {
        $tmpPath = storage_path('app/tmp');
        if (!is_dir($tmpPath)) {
            mkdir($tmpPath, 0755, true);
        }

        $tmpFile = $tmpPath . '/' . $nomeArquivo . '_' . uniqid() . '.pdf';
        file_put_contents($tmpFile, $content);

        $uploadedFile = new UploadedFile(
            $tmpFile,
            $nomeArquivo . '.pdf',
            'application/pdf',
            null,
            true
        );

        $caminhoPdf = UploadSeguroHelper::salvarImagem($uploadedFile, 'contribuicao');

        unlink($tmpFile);

        return $caminhoPdf;
    }

    private function salvarImagem($pdfUrl): string
    {
        $response = Http::get($pdfUrl);

        if (!$response->successful()) {
            throw new \Exception('Erro ao baixar PDF');
        }

        return $this->salvarPdf($response->body(), 'boleto');
    }

    private function juntarPDFs(array $pdfUrls): string
    {
        $pdf = new Fpdi();
        $tmpFiles = [];

        try {
            foreach ($pdfUrls as $pdfUrl) {
                $response = Http::get($pdfUrl);

                if (!$response->successful()) {
                    continue;
                }

                $tmpPath = storage_path('app/tmp');
                if (!is_dir($tmpPath)) {
                    mkdir($tmpPath, 0755, true);
                }

                $tmpFile = $tmpPath . '/temp_' . uniqid() . '.pdf';
                file_put_contents($tmpFile, $response->body());
                $tmpFiles[] = $tmpFile;

                $pageCount = $pdf->setSourceFile($tmpFile);

                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $template = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($template);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($template);
                }
            }

            $pdfContent = $pdf->Output('S');

            foreach ($tmpFiles as $tmpFile) {
                if (file_exists($tmpFile)) {
                    unlink($tmpFile);
                }
            }

            return $pdfContent;

        } catch (\Exception $e) {
            foreach ($tmpFiles as $tmpFile) {
                if (file_exists($tmpFile)) {
                    unlink($tmpFile);
                }
            }
            throw $e;
        }
    }

}
