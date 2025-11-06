<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa\Pessoa;

class Transacao extends BaseModel
{

    protected $table = 'material_transacao';

    protected $primaryKey = 'id_transacao';

    protected $fillable = [
        'id_tipo_movimentacao',
        'id_almoxarifado',
        'id_responsavel',
        'id_parceiro',
        'data'
    ];

    public function parceiro()
    {
        return $this->belongsTo(Parceiro::class, 'id_parceiro', 'id_parceiro');
    }

    public function tipoMovimentacao()
    {
        return $this->belongsTo(TipoMovimentacao::class, 'id_tipo_movimentacao', 'id_tipo_movimentacao');
    }

    public function almoxarifado()
    {
        return $this->belongsTo(Almoxarifado::class, 'id_almoxarifado', 'id_almoxarifado');
    }

    public function responsavel()
    {
        return $this->belongsTo(Pessoa::class, 'id_responsavel', 'id_pessoa');
    }

    public function transacaoProduto()
    {
        return $this->hasMany(TransacaoProduto::class, 'id_transacao', 'id_transacao');
    }

}
