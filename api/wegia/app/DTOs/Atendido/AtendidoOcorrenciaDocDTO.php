<?php

namespace App\DTOs\Atendido;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;

class AtendidoOcorrenciaDocDTO
{
    public int $idatendido_ocorrencia_doc;
    public int $atentido_ocorrencia_idatentido_ocorrencias;
    public string $data;
    public string $arquivo_nome;
    public string $arquivo_extensao;
    public string $arquivo;

    public function __construct(
        int $idatendido_ocorrencia_doc,
        int $atentido_ocorrencia_idatentido_ocorrencias,
        string $data,
        string $arquivo_nome,
        string $arquivo_extensao,
        string $arquivo
    ) {
        $this->idatendido_ocorrencia_doc = $idatendido_ocorrencia_doc;
        $this->atentido_ocorrencia_idatentido_ocorrencias = $atentido_ocorrencia_idatentido_ocorrencias;
        $this->data = $data;
        $this->arquivo_nome = $arquivo_nome;
        $this->arquivo_extensao = $arquivo_extensao;
        $this->arquivo = $arquivo;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['idatendido_ocorrencia_doc'],
            $data['atentido_ocorrencia_idatentido_ocorrencias'],
            $data['data'],
            $data['arquivo_nome'],
            $data['arquivo_extensao'],
            $data['arquivo'],
        );
    }

    public function toArray(): array
    {
        return [
            'idatendido_ocorrencia_doc' => $this->idatendido_ocorrencia_doc,
            'atentido_ocorrencia_idatentido_ocorrencias' => $this->atentido_ocorrencia_idatentido_ocorrencias,
            'data' => Carbon::parse($this->data)->format('d/m/Y'),
            'arquivo_nome' => $this->arquivo_nome,
            'arquivo_extensao' => $this->arquivo_extensao,
            'arquivo' => UploadSeguroHelper::urlTemporaria($this->arquivo),
        ];
    }
}
