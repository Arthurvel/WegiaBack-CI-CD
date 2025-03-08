<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class FuncionarioDocFuncional extends BaseModel
{
    protected $table = 'funcionario_docfuncional';

    protected $primaryKey = 'id_docfuncional';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'nome_docfuncional',
        'descricao_docfuncional'
    ]; 

    public function funcionarioDocs()
    {
        return $this->belongsTo(funcionarioDocs::class, 'id_docfuncional');
    }
}
