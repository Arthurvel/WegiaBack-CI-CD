<?php

namespace App\DTOs\Pessoa;

use App\DTOs\Funcionario\FuncionarioDTO;
use App\Helpers\UploadSeguroHelper;
use App\Models\Pessoa;
use Carbon\Carbon;

class PessoaDTO
{
    public int $id_pessoa;
    public string $cpf;
    public ?string $nome;
    public ?string $sobrenome;
    public ?string $sexo;
    public ?string $telefone;
    public ?string $data_nascimento;
    public ?string $imagem;
    public ?string $cep;
    public ?string $estado;
    public ?string $cidade;
    public ?string $bairro;
    public ?string $logradouro;
    public ?string $numero_endereco;
    public ?string $complemento;
    public ?string $ibge;
    public ?string $registro_geral;
    public ?string $orgao_emissor;
    public ?string $data_expedicao;
    public ?string $nome_mae;
    public ?string $nome_pai;
    public ?string $tipo_sanguineo;
    public int $nivel_acesso;
    public int $adm_configurado;
    public ?array $funcionario;

    public function __construct(
        int $id_pessoa,
        string $cpf,
        ?string $nome = null,
        ?string $sobrenome = null,
        ?string $sexo = null,
        ?string $telefone = null,
        ?string $data_nascimento = null,
        ?string $imagem = null,
        ?string $cep = null,
        ?string $estado = null,
        ?string $cidade = null,
        ?string $bairro = null,
        ?string $logradouro = null,
        ?string $numero_endereco = null,
        ?string $complemento = null,
        ?string $ibge = null,
        ?string $registro_geral = null,
        ?string $orgao_emissor = null,
        ?string $data_expedicao = null,
        ?string $nome_mae = null,
        ?string $nome_pai = null,
        ?string $tipo_sanguineo = null,
        int $nivel_acesso = 0,
        int $adm_configurado = 0,
        ?array $funcionario = null
    ) {
        $this->id_pessoa       = $id_pessoa;
        $this->cpf             = $cpf;
        $this->nome            = $nome;
        $this->sobrenome       = $sobrenome;
        $this->sexo            = $sexo;
        $this->telefone        = $telefone;
        $this->data_nascimento = $data_nascimento;
        $this->imagem          = $imagem;
        $this->cep             = $cep;
        $this->estado          = $estado;
        $this->cidade          = $cidade;
        $this->bairro          = $bairro;
        $this->logradouro      = $logradouro;
        $this->numero_endereco = $numero_endereco;
        $this->complemento     = $complemento;
        $this->ibge            = $ibge;
        $this->registro_geral  = $registro_geral;
        $this->orgao_emissor   = $orgao_emissor;
        $this->data_expedicao  = $data_expedicao;
        $this->nome_mae        = $nome_mae;
        $this->nome_pai        = $nome_pai;
        $this->tipo_sanguineo  = $tipo_sanguineo;
        $this->nivel_acesso    = $nivel_acesso;
        $this->adm_configurado = $adm_configurado;
        $this->funcionario     = $funcionario;
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            $dados['id_pessoa'],
            $dados['cpf'],
            $dados['nome'] ?? null,
            $dados['sobrenome'] ?? null,
            $dados['sexo'] ?? null,
            $dados['telefone'] ?? null,
            $dados['data_nascimento'] ?? null,
            $dados['imagem'] ?? null,
            $dados['cep'] ?? null,
            $dados['estado'] ?? null,
            $dados['cidade'] ?? null,
            $dados['bairro'] ?? null,
            $dados['logradouro'] ?? null,
            $dados['numero_endereco'] ?? null,
            $dados['complemento'] ?? null,
            $dados['ibge'] ?? null,
            $dados['registro_geral'] ?? null,
            $dados['orgao_emissor'] ?? null,
            $dados['data_expedicao'] ?? null,
            $dados['nome_mae'] ?? null,
            $dados['nome_pai'] ?? null,
            $dados['tipo_sanguineo'] ?? null,
            $dados['nivel_acesso'] ?? 0,
            $dados['adm_configurado'] ?? 0,
            $dados['funcionario'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id_pessoa'       => $this->id_pessoa,
            'cpf'             => $this->cpf,
            'nome'            => $this->nome,
            'sobrenome'       => $this->sobrenome,
            'sexo'            => $this->sexo,
            'telefone'        => $this->telefone,
            'data_nascimento' => Carbon::parse($this->data_nascimento)->format('d/m/Y'),
            'imagem'          => $this->imagem ? UploadSeguroHelper::urlTemporaria($this->imagem) : null,
            'cep'             => $this->cep,
            'estado'          => $this->estado,
            'cidade'          => $this->cidade,
            'bairro'          => $this->bairro,
            'logradouro'      => $this->logradouro,
            'numero_endereco' => $this->numero_endereco,
            'complemento'     => $this->complemento,
            'ibge'            => $this->ibge,
            'registro_geral'  => $this->registro_geral,
            'orgao_emissor'   => $this->orgao_emissor,
            'data_expedicao'  => Carbon::parse($this->data_expedicao)->format('d/m/Y'),
            'nome_mae'        => $this->nome_mae,
            'nome_pai'        => $this->nome_pai,
            'tipo_sanguineo'  => $this->tipo_sanguineo,
            'nivel_acesso'    => $this->nivel_acesso,
            'adm_configurado' => $this->adm_configurado,
            'funcionario'     => $this->funcionario ? FuncionarioDTO::fromArray($this->funcionario) : null
        ];
    }

    public function toModel(): Pessoa
    {
        $atributos = [
            'id' => $this->id_pessoa,
            'cpf' => $this->cpf,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'sexo' => $this->sexo,
            'telefone' => $this->telefone,
            'data_nascimento' => $this->data_nascimento ? Carbon::createFromFormat('d/m/Y', $this->data_nascimento)->format('Y-m-d') : null,
            'imagem' => $this->imagem,
            'cep' => $this->cep,
            'estado' => $this->estado,
            'cidade' => $this->cidade,
            'bairro' => $this->bairro,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero_endereco,
            'complemento' => $this->complemento,
            'ibge' => $this->ibge,
            'rg' => $this->registro_geral,
            'orgao_emissor' => $this->orgao_emissor,
            'data_expedicao' => $this->data_expedicao ? Carbon::createFromFormat('d/m/Y', $this->data_expedicao)->format('Y-m-d') : null,
            'nome_mae' => $this->nome_mae,
            'nome_pai' => $this->nome_pai,
            'tipo_sanguineo' => $this->tipo_sanguineo,
            'nivel_acesso' => $this->nivel_acesso,
            'adm_configurado' => $this->adm_configurado
        ];

        return new Pessoa($atributos);
    }
}