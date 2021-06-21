<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspensionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspensiones', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->integer('id_cliente');
            $table->integer('id_usuario');
            $table->integer('id_tecnico');
            $table->string('motivo')->nullable();
            $table->date('fecha_trabajo')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('tipo_servicio');
            $table->integer('suspendido');
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
        Schema::dropIfExists('suspensiones');
    }
}
