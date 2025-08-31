<?php

namespace App\Http\Resources\Pessoa;

use App\Helpers\UploadSeguroHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Funcionario\FuncionarioResource;
use Carbon\Carbon;

class PessoaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pessoa'       => $this->id_pessoa,
            'cpf'             => $this->cpf,
            'nome'            => $this->nome,
            'sobrenome'       => $this->sobrenome,
            'sexo'            => $this->sexo,
            'telefone'        => $this->telefone,
            'data_nascimento' => $this->data_nascimento ? Carbon::parse($this->data_nascimento)->format('d/m/Y') : null,
            'imagem'          => $this->imagem ? UploadSeguroHelper::urlTemporaria($this->imagem)  : null,
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
            'data_expedicao'  => $this->data_expedicao ? Carbon::parse($this->data_expedicao)->format('d/m/Y') : null,
            'nome_mae'        => $this->nome_mae,
            'nome_pai'        => $this->nome_pai,
            'tipo_sanguineo'  => $this->tipo_sanguineo,
            'nivel_acesso'    => $this->nivel_acesso,
            'adm_configurado' => $this->adm_configurado,
            'funcionario'     => $this->relationLoaded('funcionario') ? new FuncionarioResource($this->funcionario) : null,
            'avisos'          => $this->relationLoaded('avisos') ? AvisoResource::collection($this->avisos) : null
        ];
    }
}
