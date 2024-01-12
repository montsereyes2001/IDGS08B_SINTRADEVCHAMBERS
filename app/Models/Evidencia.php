<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;
    protected $table='evidencias';
    protected $primary_key='id';
    public $timestamps = true;

    protected $fillable=[
        'id_bitacora',
        'id_icono',
        'nombre',
        'nombre_foto',
        'foto',
        'latitud',
        'longitud',
        'altitud',
        'descripcion',
        'status'
    ];
}
