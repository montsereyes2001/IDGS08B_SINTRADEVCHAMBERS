<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
    use HasFactory;
    protected $table='tipo_trabajos';
    protected $primary_key='id';
    public $timestamps = false;

    protected $fillable=[
        'id_trabajo',
        'nombre',
        'status'
    ];
}
