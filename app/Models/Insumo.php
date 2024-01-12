<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;
    protected $table='insumos';
    protected $primary_key='id';
    protected $fillable=[
        'id_evidencia',
        'id_producto',
        'cantidad',
        'status'
    ];
}
