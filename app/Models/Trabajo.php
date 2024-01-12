<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;
    protected $table='trabajos';
    protected $primary_key='id';
    public $timestamps = false;

    protected $fillable=[
        'nombre',
        'status'
    ];
}
