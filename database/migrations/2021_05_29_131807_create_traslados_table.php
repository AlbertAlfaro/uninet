<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrasladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traslados', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->integer('id_cliente');
            $table->integer('id_usuario');
            $table->integer('id_tecnico');
            $table->string('nueva_direccion')->nullable();
            $table->integer('id_municipio');
            $table->string('rx')->nullable();
            $table->string('tx')->nullable();
            $table->date('fecha_trabajo')->nullable();
            $table->string('observacion')->nullable();
            $table->string('tipo_servicio');
            $table->integer('update_direc');
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
        Schema::dropIfExists('traslados');
    }
}
