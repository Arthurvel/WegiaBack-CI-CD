<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produto extends BaseModel
{
    protected $table = 'material_produto';

    protected $primaryKey = 'id_produto';

    protected $fillable = [
        'id_categoria',
        'id_unidade',
        'descricao',
        'codigo',
        'oculto'
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class, 'id_unidade');
    }
}

