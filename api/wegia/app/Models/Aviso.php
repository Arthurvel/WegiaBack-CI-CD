<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa\Pessoa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aviso extends BaseModel
{

    protected $table = 'aviso';

    protected $primaryKey = 'id_aviso';

    protected $fillable = [
        'id_pessoa',
        'titulo',
        'descricao',
        'nivel',
        'ativo'
    ];

    public function pessoa() : BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

}
