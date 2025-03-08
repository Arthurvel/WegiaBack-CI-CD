<?php

namespace App\DTOs\Funcionario;

use App\DTOs\Pessoa\PessoaDTO;
use App\DTOs\Cargo\CargoDTO;
use App\DTOs\Situacao\SituacaoDTO;

class FuncionarioDTO
{
    public int $id_funcionario;
    public int $id_pessoa;
    public ?PessoaDTO $pessoa;
    public int $id_cargo;
    public ?string $cargo;
    public int $id_situacao;
    public ?string $situacao;
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
        int $id_funcionario,
        int $id_pessoa,
        ?PessoaDTO $pessoa = null,
        int $id_cargo,
        ?string $cargo = null,
        int $id_situacao,
        ?string $situacao = null,
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
        $this->id_funcionario                = $id_funcionario;
        $this->pessoa                        = $pessoa;
        $this->id_pessoa                     = $id_pessoa;
        $this->id_cargo                      = $id_cargo;
        $this->cargo                         = $cargo;
        $this->id_situacao                   = $id_situacao;
        $this->situacao                      = $situacao;
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
            $dados['id_funcionario'],
            $dados['id_pessoa'],
            isset($dados['pessoa'])   ? PessoaDTO::fromArray($dados['pessoa']) : null,
            $dados['id_cargo'],
            $dados['cargo']['cargo'] ?? null,
            $dados['id_situacao'],
            $dados['situacao']['situacoes'] ?? null,
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
            'id_funcionario'                => $this->id_funcionario,
            'pessoa'                        => $this->pessoa,
            'cargo'                         => $this->cargo,
            'situacao'                      => $this->situacao,
            'id_pessoa'                     => $this->id_pessoa,
            'id_cargo'                      => $this->id_cargo,
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