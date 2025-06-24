<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa;

class FuncionarioDependente extends BaseModel
{
    protected $table = 'funcionario_dependentes';

    protected $primaryKey = 'id_dependente';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_funcionario',
        'id_pessoa',
        'id_parentesco'
    ]; 

    public function pessoa()
    {
        return $this->hasOne(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function funcionario()
    {
        return $this->hasOne(Funcionario::class, 'id_funcionario', 'id_funcionario');
    }

    public function parentesco()
    {
        return $this->hasOne(FuncionarioDependenteParentesco::class, 'id_parentesco','id_parentesco');
    }
}
