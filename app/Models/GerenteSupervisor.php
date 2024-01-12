<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GerenteSupervisor extends Model
{
    use HasFactory;
    protected $table='gerente_supervisor';
    protected $primary_id='id';
    public $timestamps = false;

    protected $fillable=[
        'id_gerente',
        'id_supervisor',
        'status'
    ];
}
