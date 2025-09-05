<?php

namespace Modules\Memorando\app\Models;

use App\Models\BaseModel\BaseModel;
use app\Models\Pessoa\Pessoa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
