<?php

namespace Modules\Memorando\app\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa;

class Memorando extends BaseModel
{
    protected $table = 'memorando';

    protected $primaryKey = 'id_memorando';

    protected $fillable = [
        'id_pessoa',
        'status_memorando',
        'titulo',
        'data'
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function despachos(): HasMany
    {
        return $this->hasMany(Despacho::class, 'id_memorando', 'id_memorando');
    }
}
