<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerente extends Model
{
    use HasFactory;
    protected $table='gerentes';
    protected $primary_key='id';
    protected $fillable=[
        'id_usuario',
        'estado',
    ];
}
