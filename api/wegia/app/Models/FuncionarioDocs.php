<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class FuncionarioDocs extends BaseModel
{
    protected $table = 'funcionario_docs';

    protected $primaryKey = 'id_fundocs';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_funcionario',
        'id_docfuncional',
        'data',
        'extensao_arquivo',
        'nome_arquivo',
        'arquivo'
    ]; 

    public function funcionarioDocFuncional()
    {
        return $this->belongsTo(FuncionarioDocFuncional::class, 'id_docfuncional');
    }
}
