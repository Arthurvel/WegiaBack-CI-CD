<?php

namespace Modules\ContribuicaoSocios\app\Models;
use App\Models\BaseModel\BaseModel;

class ContribuicaoConjuntoRegras extends BaseModel
{
    protected $table = 'contribuicao_conjuntoRegras';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_meioPagamento',
        'id_regra',
        'valor',
        'status'
    ];

    public function meioPagamento()
    {
        return $this->belongsTo(ContribuicaoMeioDePagamento::class, 'id_meioPagamento');
    }

    public function regra()
    {
        return $this->belongsTo(ContribuicaoRegras::class, 'id_regra');
    }

}
