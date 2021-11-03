<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->integer('id_cliente');
            $table->integer('id_cobrador')->nullable();
            $table->float('sumas')->nullable();
            $table->float('iva')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('suma_gravada')->nullable();
            $table->float('venta_exenta')->nullable();
            $table->float('retencion')->nullable();
            $table->float('percepcion')->nullable();
            $table->float('total_menos_retencion')->nullable();
            $table->float('total_menos_percepcion')->nullable();
            $table->float('total')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->string('tipo')->nullable();//CREDITO FISCAL
            $table->string('serie')->nullable();
            $table->string('tipo_documento')->nullable();//CCF O CCF
            $table->string('numero_documento')->nullable();
            $table->integer('impresa');
            $table->integer('cuota');
            $table->string('anulada');
            $table->integer('tipo_servicio')->nullable();
            $table->integer('id_sucursal')->nullable();
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
        Schema::dropIfExists('facturas');
    }
}
