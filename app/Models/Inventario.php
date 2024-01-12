<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $table='inventarios';
    protected $primary_key='id';
    
    protected $fillable=[
        'id_rama',
        'id_producto',
        'cantidad',
        'status'
    ];
}
