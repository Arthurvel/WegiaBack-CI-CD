<?php

namespace App\Models\Pessoa;

use Illuminate\Database\Eloquent\Model;

class PessoaDependente extends Model
{
    protected $table = 'pessoa_dependente';

    protected $primaryKey = 'id_dependente';

    public $timestamps = false;

    protected $fillable = [
        'id_pessoa',
        'id_dependente_pessoa',
        'parentesco',
    ];

    protected $casts = [
        'parentesco' => PessoaParentescoEnum::class,
    ];

    public function titular()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

    public function dependente()
    {
        return $this->belongsTo(Pessoa::class, 'id_dependente_pessoa');
    }
}
