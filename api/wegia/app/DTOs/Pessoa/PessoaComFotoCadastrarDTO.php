<?php

namespace App\DTOs\Pessoa;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class PessoaComFotoCadastrarDTO extends BaseDTO
{
    public ?string $nome;
    public ?string $sobrenome;
    public string  $cpf;
    public ?string $sexo;
    public ?string $telefone;
    public ?string $data_nascimento;
    public ?UploadedFile $imagem;
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
    public ?int $nivel_acesso;
    public ?int $adm_configurado;

}
