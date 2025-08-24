<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;
use app\Models\Pessoa\Pessoa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adocao extends BaseModel
{

    protected $table = 'pet_adocao';

    protected $primaryKey = 'id_adocao';

    protected $fillable = [
        'id_pessoa',
        'id_pet',
        'data_adocao'
    ];

    public function pessoa() : BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

}
