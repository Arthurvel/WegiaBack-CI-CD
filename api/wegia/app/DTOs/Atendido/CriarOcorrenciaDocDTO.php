<?php

namespace App\DTOs\Atendido;

use Carbon\Carbon;

class CriarOcorrenciaDocDTO
{
    public int $atentido_ocorrencia_idatentido_ocorrencias;
    public string $data;
    public string $arquivo_nome;
    public string $arquivo_extensao;
    public string $arquivo;

    public function __construct(
        int $atentido_ocorrencia_idatentido_ocorrencias,
        string $data,
        string $arquivo_nome,
        string $arquivo_extensao,
        string $arquivo,
    ) {
        $this->atentido_ocorrencia_idatentido_ocorrencias = $atentido_ocorrencia_idatentido_ocorrencias;
        $this->data                                       = $data;
        $this->arquivo_nome                               = $arquivo_nome;
        $this->arquivo_extensao                           = $arquivo_extensao;
        $this->arquivo                                    = $arquivo;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['atentido_ocorrencia_idatentido_ocorrencias'],
            $dados['data'],
            $dados['arquivo_nome'],
            $dados['arquivo_extensao'],
            $dados['arquivo'],
        );
    }

    public function toArray(): array
    {
        return [
            'atentido_ocorrencia_idatentido_ocorrencias' => $this->atentido_ocorrencia_idatentido_ocorrencias,
            'data'                                       => $this->data,
            'arquivo_nome'                               => $this->arquivo_nome,
            'arquivo_extensao'                           => $this->arquivo_extensao,
            'arquivo'                                    => $this->arquivo

        ];
    }
}