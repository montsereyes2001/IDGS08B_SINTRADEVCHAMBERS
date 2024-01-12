<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table='clientes';
    protected $primary_key='id';
    public $timestamps = false;

    protected $fillable=[
        'nombre_empresa',
        'ciudad',
        'estado',
        'status'
    ];
}
