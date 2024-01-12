<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rama extends Model
{
    use HasFactory;
    protected $table='ramas';
    protected $primary_key='id';
    public $timestamps=false;

    protected $fillable=[
        'nombre',
        'hub',
        'id_cliente',
        'id_invitado',
        'status'
    ];
}
