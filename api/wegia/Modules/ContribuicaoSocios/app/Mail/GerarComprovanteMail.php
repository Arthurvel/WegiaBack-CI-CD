<?php

namespace Modules\ContribuicaoSocios\app\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GerarComprovanteMail extends Mailable
{

    use Queueable, SerializesModels;

    public string $titulo;
    public string $nome;
    public string $valorTotal;
    public string $periodoInicio;
    public string $periodoFim;
    public string $dataEnvio;

    private string $pdf;

    public function __construct(
        string $nome,
        string $valorTotal,
        string $periodoInicio,
        string $periodoFim,
        string $pdf
    )
    {
        $this->nome          = $nome;
        $this->valorTotal    = $valorTotal;
        $this->periodoInicio = $periodoInicio;
        $this->periodoFim    = $periodoFim;
        $this->titulo        = config('contribuicaosocios.titulo_email');
        $this->dataEnvio     = date('d/m/Y H:i:s');

        $this->pdf   = $pdf;
    }

    public function build()
    {
        return $this
            ->subject('Comprovante de Pagamento - ' . $this->titulo)
            ->view('contribuicaosocios::emails.gerar-comprovante')
            ->attachData(
                $this->pdf,
               'comprovante.pdf',
                ['mime' => 'application/pdf']
            );
    }

}
