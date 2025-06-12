<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioDependenteParentesco extends BaseModel
{
    protected $table = 'funcionario_dependente_parentesco';

    protected $primaryKey = 'id_parentesco';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao',
    ]; 
}
