<?php

namespace App\Models\Pet;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atendimento extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_atendimento';
    
    protected $primaryKey = 'id_pet_atendimento';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_ficha_medica','data_atendimento', 'descricao'];
    
    
}
