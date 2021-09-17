<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_factura')->nullable();
            $table->integer('id_cliente')->nullable();
            $table->integer('id_cobrador')->nullable();
            $table->integer('id_usuario')->nullable();
            $table->string('recibo')->nullable();
            $table->string('tipo_servicio')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->date('mes_servicio')->nullable();
            $table->date('fecha_aplicado')->nullable();
            $table->date('fecha_vence')->nullable();
            $table->float('cargo')->nullable();
            $table->float('abono')->nullable();
            $table->float('cesc_cargo')->nullable();
            $table->float('cesc_abono')->nullable();
            $table->float('precio')->nullable();
            $table->integer('anulado');
            $table->integer('pagado');
            $table->integer('exento')->nullable();
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
        Schema::dropIfExists('abonos');
    }
}
