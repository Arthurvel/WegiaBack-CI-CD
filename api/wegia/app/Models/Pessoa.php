<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Pessoa extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'pessoa';

    protected $primaryKey = 'id_pessoa';

    public $timestamps = false;

    protected $fillable = [
        'cpf',
        'senha',
        'nome',
        'sobrenome',
        'sexo',
        'telefone',
        'data_nascimento',
        'imagem',
        'cep',
        'estado',
        'cidade',
        'bairro',
        'logradouro',
        'numero_endereco',
        'complemento',
        'ibge',
        'registro_geral',
        'orgao_emissor',
        'data_expedicao',
        'nome_mae',
        'nome_pai',
        'tipo_sanguineo',
        'nivel_acesso',
        'adm_configurado',
    ];    

    protected $hidden = [
        'senha',
    ];   

    protected $casts = [
        'data_nascimento' => 'date',
        'data_expedicao' => 'date',
    ];

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = Hash::make($value);
    }

    public function validarSenha(string $senha) : bool
    {
        return Hash::check($senha, $this->senha);
    }

    public function funcionario()
    {
        return $this->hasMany(Funcionario::class, 'id_pessoa');
    }

}
