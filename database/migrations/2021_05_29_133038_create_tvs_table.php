<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cliente');
            $table->string('numero_contrato');
            $table->date('fecha_instalacion')->nullable();
            $table->float('costo_instalacion')->nullable();
            $table->date('fecha_primer_fact')->nullable();
            $table->float('cuota_mensual');
            $table->string('prepago')->nullable();
            $table->string('dia_gene_fact');
            $table->date('contrato_vence')->nullable();
            $table->string('periodo')->nullable();
            $table->string('cortesia')->nullable();
            $table->string('digital')->nullable();
            $table->string('marca')->nullable();
            $table->string('serie')->nullable();
            $table->string('modelo')->nullable();
            $table->integer('identificador');
            $table->integer('activo');
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
        Schema::dropIfExists('tvs');
    }
}
