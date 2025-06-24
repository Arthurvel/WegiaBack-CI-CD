<?php

namespace App\DTOs\Funcionario;

class AtualizarFuncionarioDTO
{
    public ?int $id_cargo;
    public ?int $id_situacao;
    public ?string $data_admissao;
    public ?string $pis;
    public ?string $ctps;
    public ?string $uf_ctps;
    public ?string $numero_titulo;
    public ?string $zona;
    public ?string $secao;
    public ?string $certificado_reservista_numero;
    public ?string $certificado_reservista_serie;


    public function __construct(
        ?int $id_cargo = null,
        ?int $id_situacao = null,
        ?string $data_admissao = null,
        ?string $ctps = null,
        ?string $pis = null,
        ?string $uf_ctps = null,
        ?string $numero_titulo = null,
        ?string $zona = null,
        ?string $secao = null,
        ?string $certificado_reservista_numero = null,
        ?string $certificado_reservista_serie = null
    ) {
        $this->id_cargo                      = $id_cargo;
        $this->id_situacao                   = $id_situacao;
        $this->data_admissao                 = $data_admissao;
        $this->ctps                          = $ctps;
        $this->pis                           = $pis;
        $this->uf_ctps                       = $uf_ctps;
        $this->numero_titulo                 = $numero_titulo;
        $this->zona                          = $zona;
        $this->secao                         = $secao;
        $this->certificado_reservista_numero = $certificado_reservista_numero;
        $this->certificado_reservista_serie  = $certificado_reservista_serie;
    }

    public static function fromArray(array $dados): self
    {
        return new self( 
            $dados['id_cargo'] ?? null,
            $dados['id_situacao'] ?? null,
            $dados['data_admissao'] ?? null,
            $dados['ctps'] ?? null,
            $dados['pis'] ?? null,
            $dados['uf_ctps'] ?? null,
            $dados['numero_titulo'] ?? null,
            $dados['zona'] ?? null,
            $dados['secao'] ?? null,
            $dados['certificado_reservista_numero'] ?? null,
            $dados['certificado_reservista_serie'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id_cargo'                      => $this->id_cargo,
            'id_situacao'                   => $this->id_situacao,
            'data_admissao'                 => $this->data_admissao,
            'ctps'                          => $this->ctps,
            'pis'                           => $this->pis,
            'uf_ctps'                       => $this->uf_ctps,
            'numero_titulo'                 => $this->numero_titulo,
            'zona'                          => $this->zona,
            'secao'                         => $this->secao,
            'certificado_reservista_numero' => $this->certificado_reservista_numero,
            'certificado_reservista_serie'  => $this->certificado_reservista_serie,
        ], function ($valor) {
            return !is_null($valor);
        });
    }
}