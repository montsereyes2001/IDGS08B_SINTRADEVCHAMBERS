<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorLider extends Model
{
    use HasFactory;
    protected $table='supervisor_lider';
    protected $primary_id='id';
    public $timestamps = false;

    protected $fillable=[
        'id_supervisor',
        'id_lider',
        'status'
    ];
}
