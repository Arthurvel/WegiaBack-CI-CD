<?php

namespace App\Models\Pet;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicacao extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_medicacao';
    
    protected $primaryKey = 'id_medicacao';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_medicamento','id_pet_atendimento', 'data_medicacao'];
    
    
}
