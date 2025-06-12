<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioRemuneracaoTipo extends BaseModel
{
    protected $table = 'funcionario_remuneracao_tipo';

    protected $primaryKey = 'idfuncionario_remuneracao_tipo';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao',
    ]; 

    public function remuneracao()
    {
        return $this->hasMany(FuncionarioRemuneracao::class, 'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo');
    }

}
