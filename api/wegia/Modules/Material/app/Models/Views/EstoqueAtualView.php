<?php

namespace Modules\Material\app\Models\Views;

use App\Models\BaseModel\BaseModel;

class EstoqueAtualView extends BaseModel
{

    protected $table = 'view_estoque_atual';
    protected $primaryKey = 'id_produto';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_produto',
        'nome_produto',
        'id_almoxarifado',
        'estoque',
    ];

}
