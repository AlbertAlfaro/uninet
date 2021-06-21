<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReconexionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reconexions', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->integer('id_cliente');
            $table->integer('id_usuario');
            $table->integer('id_tecnico');
            $table->string('observacion')->nullable();
            $table->date('fecha_trabajo')->nullable();
            $table->string('tipo_servicio');
            $table->integer('contrato')->nullable();
            $table->string('n_contrato')->nullable();
            $table->string('rx')->nullable();
            $table->string('tx')->nullable();
            $table->string('activado');
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
        Schema::dropIfExists('reconexions');
    }
}
