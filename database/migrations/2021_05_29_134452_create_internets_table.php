<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internets', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cliente');
            $table->date('fecha_instalacion')->nullable();
            $table->date('fecha_primer_fact')->nullable();
            $table->float('cuota_mensual');
            $table->string('prepago')->nullable();
            $table->string('dia_gene_fact');
            $table->date('contrato_vence')->nullable();
            $table->string('periodo')->nullable();
            $table->string('velocidad')->nullable();
            $table->string('marca')->nullable();
            $table->string('mac')->nullable();
            $table->string('serie')->nullable();
            $table->string('recepcion')->nullable();
            $table->string('trasmision')->nullable();
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('internets');
    }
}
