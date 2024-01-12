<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $table='bitacoras';
    protected $primary_key='id';

    protected $fillable=[
        'id_tipo_trabajo',
        'id_rama',
        // 'id_lider',
        'ciudad',
        'estado',
        'estatus',
        'id_supervisor_lider'
    ];
}
