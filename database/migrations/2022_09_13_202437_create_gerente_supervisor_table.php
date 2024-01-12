<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGerenteSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gerente_supervisor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_gerente');
            $table->foreign('id_gerente')->references('id')->on('gerentes');
            $table->unsignedBigInteger('id_supervisor');
            $table->foreign('id_supervisor')->references('id')->on('supervisores');
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
        Schema::dropIfExists('gerente_supervisor');
    }
}
