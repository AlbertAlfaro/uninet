<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrelativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correlativos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('resolucion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('serie')->nullable();
            $table->integer('desde')->nullable();
            $table->integer('hasta')->nullable();
            $table->integer('ultimo')->nullable();
            $table->integer('cantidad')->nullable();
            $table->integer('id_sucursal');
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
        Schema::dropIfExists('correlativos');
    }
}
