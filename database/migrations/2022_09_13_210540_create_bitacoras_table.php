<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tipo_trabajo');
            $table->foreign('id_tipo_trabajo')->references('id')->on('tipo_trabajos');
            $table->unsignedBigInteger('id_rama');
            $table->foreign('id_rama')->references('id')->on('ramas');
            // $table->unsignedBigInteger('id_lider');
            // $table->foreign('id_lider')->references('id')->on('lideres');
            $table->string('ciudad');
            $table->string('estado');
            $table->string('estatus');
            $table->unsignedBigInteger('id_supervisor_lider');
            $table->foreign('id_supervisor_lider')->references('id')->on('supervisor_lider');
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
        Schema::dropIfExists('bitacoras');
    }
}
