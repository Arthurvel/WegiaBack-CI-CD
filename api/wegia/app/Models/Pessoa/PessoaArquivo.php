<?php

namespace app\Models\Pessoa;

use App\Models\BaseModel\BaseModel;

class PessoaArquivo extends BaseModel
{

    protected $table = 'pessoa_arquivo';
    protected $primaryKey = 'id_pessoa_arquivo';
    public $timestamps = false;

    protected $fillable = [
        'id_pessoa',
        'id_pessoa_tipo_arquivo',
        'data',
        'extensao_arquivo',
        'nome_arquivo',
        'arquivo'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function tipoArquivo()
    {
        return $this->belongsTo(PessoaTipoArquivo::class, 'id_pessoa_tipo_arquivo', 'id_pessoa_tipo_arquivo');
    }

}
