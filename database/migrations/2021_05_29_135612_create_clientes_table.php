<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('dui');
            $table->string('nit')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono1');
            $table->string('telefono2')->nullable();
            $table->integer('id_municipio');
            $table->string('dirreccion');
            $table->string('dirreccion_cobro');
            $table->string('numero_registro')->nullable();
            $table->string('giro')->nullable();
            $table->string('colilla');
            $table->string('tipo_documento');
            $table->string('referencia1')->nullable();
            $table->string('telefo1')->nullable();
            $table->string('referencia2')->nullable();
            $table->string('telefo2')->nullable();
            $table->string('referencia3')->nullable();
            $table->string('telefo3')->nullable();
            $table->string('tv');
            $table->string('internet');
            $table->string('cordenada')->nullable();
            $table->string('nodo')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
