<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'pessoa';

    protected $primaryKey = 'id_pessoa';

    protected $hidden = [
        'senha',
    ];

}
