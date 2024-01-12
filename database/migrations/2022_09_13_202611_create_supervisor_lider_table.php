<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervisorLiderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisor_lider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_supervisor');
            $table->foreign('id_supervisor')->references('id')->on('supervisores');
            $table->unsignedBigInteger('id_lider');
            $table->foreign('id_lider')->references('id')->on('lideres');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supervisor_lider');
    }
}
