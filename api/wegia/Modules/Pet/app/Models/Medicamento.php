<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicamento extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_medicamento';

    protected $primaryKey = 'id_medicamento';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nome_medicamento','descricao_medicamento', 'aplicacao'];
}
