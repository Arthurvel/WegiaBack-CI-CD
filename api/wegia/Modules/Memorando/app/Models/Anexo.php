<?php

namespace Modules\Memorando\app\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\BaseModel\BaseModel;

class Anexo extends BaseModel
{
    protected $table = 'anexo';

    protected $primaryKey = 'id_anexo';

    protected $fillable = [
        'id_despacho',
        'anexo',
        'extensao',
        'nome'
    ];

    public function despacho(): BelongsTo
    {
        return $this->belongsTo(Despacho::class, 'id_despacho', 'id_despacho');
    }
}
