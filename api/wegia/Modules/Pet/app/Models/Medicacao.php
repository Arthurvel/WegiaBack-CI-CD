<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Medicacao extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_medicacao';

    protected $primaryKey = 'id_medicacao';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_medicamento','id_pet_atendimento', 'data_medicacao'];

    public function medicamento() : HasOne
    {
        return $this->hasOne(Medicamento::class, 'id_medicamento');
    }

}
