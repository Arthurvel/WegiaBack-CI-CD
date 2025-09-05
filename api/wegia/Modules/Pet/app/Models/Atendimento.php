<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atendimento extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_atendimento';

    protected $primaryKey = 'id_pet_atendimento';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_ficha_medica','data_atendimento', 'descricao'];

    public function medicacao() : HasMany
    {
        return $this->hasMany(Medicacao::class, 'id_pet_atendimento');
    }

}

