<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory;
    protected $table='invitados';
    protected $primary_key='id';

    protected $fillable=[
        'nombre',
        'password',
        'estado',
    ];
}
