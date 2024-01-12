<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialBitacora extends Model
{
    use HasFactory;
    protected $table = 'material_bitacora';
    protected $primary_key = 'id';

    protected $fillable = [
        'id_bitacora',
        'id_productos',
        'status'
    ];
}
/*$table->id();
            $table->unsignedBigInteger('id_bitacora');
            $table->foreign('id_bitacora')->references('id')->on('bitacoras');
            $table->unsignedBigInteger('id_productos');
            $table->foreign('id_productos')->references('id')->on('productos');
            $table->string('status'); */
