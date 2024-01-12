<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoCliente extends Model
{
    use HasFactory;
    protected $table='contacto_cliente';
    protected $primary_key='id';
    public $timestamps = false;

    protected $fillable=[
        'id_cliente',
        'contacto_email',
        'contacto_nombre',
        'contacto_cargo',
        'telefono',
        'status'
    ];
}
