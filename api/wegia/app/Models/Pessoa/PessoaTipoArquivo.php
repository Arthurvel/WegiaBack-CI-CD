<?php

namespace app\Models\Pessoa;

use App\Models\BaseModel\BaseModel;

class PessoaTipoArquivo extends BaseModel
{

    protected $table = 'pessoa_tipo_arquivo';
    protected $primaryKey = 'id_pessoa_tipo_arquivo';
    public $timestamps = false;

    protected $fillable = [
        'descricao'
    ];

    public function arquivos()
    {
        return $this->hasMany(PessoaArquivo::class, 'id_pessoa_tipo_arquivo', 'id_pessoa_tipo_arquivo');
    }

}
