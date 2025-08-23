<?php

namespace App\DTOs\Funcionario;

class CadastrarFuncionarioDTO
{
    public int $id_pessoa;
    public int $id_perfil;
    public int $id_situacao;
    public string $data_admissao;
    public ?string $pis;
    public string $ctps;
    public ?string $uf_ctps;
    public ?string $numero_titulo;
    public ?string $zona;
    public ?string $secao;
    public ?string $certificado_reservista_numero;
    public ?string $certificado_reservista_serie;

    public function __construct(
        int $id_pessoa,
        int $id_perfil,
        int $id_situacao,
        string $data_admissao,
        string $ctps,
        ?string $pis = null,
        ?string $uf_ctps = null,
        ?string $numero_titulo = null,
        ?string $zona = null,
        ?string $secao = null,
        ?string $certificado_reservista_numero = null,
        ?string $certificado_reservista_serie = null
    ) {
        $this->id_pessoa                     = $id_pessoa;
        $this->id_perfil                      = $id_perfil;
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
            $dados['id_pessoa'],
            $dados['id_perfil'],
            $dados['id_situacao'],
            $dados['data_admissao'],
            $dados['ctps'] ?? '',
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
        return [
            'id_pessoa'                     => $this->id_pessoa,
            'id_perfil'                      => $this->id_perfil,
            'id_situacao'                   => $this->id_situacao,
            'data_admissao'                 => $this->data_admissao,
            'pis'                           => $this->pis,
            'ctps'                          => $this->ctps,
            'uf_ctps'                       => $this->uf_ctps,
            'numero_titulo'                 => $this->numero_titulo,
            'zona'                          => $this->zona,
            'secao'                         => $this->secao,
            'certificado_reservista_numero' => $this->certificado_reservista_numero,
            'certificado_reservista_serie'  => $this->certificado_reservista_serie,
        ];
    }
}
