<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FichaMedica extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_ficha_medica';

    protected $primaryKey = 'id_ficha_medica';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_pet','castrado', 'necessidades_especiais'];

    public function atendimento() : HasMany
    {
        return $this->hasMany(Atendimento::class, 'id_ficha_medica');
    }

}

