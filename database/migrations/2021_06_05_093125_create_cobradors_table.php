<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobradors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('resolucion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('serie')->nullable();
            $table->integer('recibo_desde')->nullable();
            $table->integer('recibo_hasta')->nullable();
            $table->integer('recibo_ultimo')->nullable();
            $table->integer('cof_desde')->nullable();
            $table->integer('cof_hasta')->nullable();
            $table->integer('cof_ultimo')->nullable();
            $table->integer('ccf_desde')->nullable();
            $table->integer('ccf_hasta')->nullable();
            $table->integer('ccf_ultimo')->nullable();
            $table->integer('activo')->nullable();
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
        Schema::dropIfExists('cobradors');
    }
}
