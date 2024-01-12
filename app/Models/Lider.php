<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lider extends Model
{
    use HasFactory;
    protected $table='lideres';
    protected $primary_key='id';

    protected $fillable=[
        'id_usuario',
        'estado',
    ];
}
