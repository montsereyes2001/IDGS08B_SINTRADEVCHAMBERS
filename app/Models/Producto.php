<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table='productos';
    protected $primary_key='id';
    public $timestamps = false;

    protected $fillable = [
        'codigo_inicial',
        'nombre',
        'categoria',
        'descripcion',
        'status'
    ];
}
