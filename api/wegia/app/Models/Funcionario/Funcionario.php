<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;
use App\Models\Cargo;
use App\Models\Funcionario\Perfil\FuncionarioPerfil;
use App\Models\Pessoa\Pessoa;
use App\Models\Situacao;

class Funcionario extends BaseModel
{
    protected $table = 'funcionario';

    protected $primaryKey = 'id_funcionario';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_pessoa',
        'id_cargo',
        'id_situacao',
        'id_perfil',
        'data_admissao',
        'pis',
        'ctps',
        'uf_ctps',
        'numero_titulo',
        'zona',
        'secao',
        'certificado_reservista_numero',
        'certificado_reservista_serie',
    ];

    protected $hidden = [
        'senha',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }

    public function situacao()
    {
        return $this->belongsTo(Situacao::class, 'id_situacao');
    }

    public function perfil()
    {
        return $this->belongsTo(FuncionarioPerfil::class, 'id_perfil', 'id_perfil');
    }
}
