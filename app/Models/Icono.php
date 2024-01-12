<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icono extends Model
{
    use HasFactory;
    protected $table='iconos';
    protected $primary_key='id';
    public $timestamps = false;
    protected $fillable=[
        'nombre',
        'url',
        'status'
    ];
}
