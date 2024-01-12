<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;
    protected $table='administradores';
    protected $primary_key='id';
    public $timestamps=false;

    protected $fillable=[
        'id_usuario',
        'status'
    ];
}
