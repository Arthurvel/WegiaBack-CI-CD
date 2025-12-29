<?php

namespace App\Models\Pessoa;

use App\Models\Aviso;
use App\Models\Funcionario\Funcionario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Modules\ContribuicaoSocios\app\Models\Socio;

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
        return $this->hasOne(Funcionario::class, 'id_pessoa');
    }

    public function avisos() : HasMany
    {
        return $this->hasMany(Aviso::class, 'id_pessoa', 'id_pessoa')->where('ativo', true);
    }

    public function arquivos()
    {
        return $this->hasMany(PessoaArquivo::class, 'id_pessoa', 'id_pessoa');
    }

    public function socio()
    {
        return $this->hasOne(Socio::class, 'id_pessoa');
    }

}
