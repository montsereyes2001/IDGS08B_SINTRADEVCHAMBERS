<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bitacora');
            $table->foreign('id_bitacora')->references('id')->on('bitacoras');
            $table->unsignedBigInteger('id_icono');
            $table->foreign('id_icono')->references('id')->on('iconos');
            $table->strng('nombre');
            $table->strng('nombre_foto');
            $table->binary('foto');
            $table->decimal('latitud', 11, 8);
            $table->decimal('longitud', 11, 8);
            $table->float('altitud');
            $table->string('descripcion');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencias');
    }
}
