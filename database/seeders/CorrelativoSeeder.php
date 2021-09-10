<?php

namespace Database\Seeders;
use App\Models\Correlativo;
use Illuminate\Database\Seeder;

class CorrelativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $correlativo= new Correlativo();
        $correlativo->nombre="cof";
        $correlativo->serie="";
        $correlativo->desde="1";
        $correlativo->hasta="10000";
        $correlativo->ultimo="0";
        $correlativo->cantidad="10000";
        $correlativo->id_sucursal="1";
        $correlativo->save();

        $correlativo= new Correlativo();
        $correlativo->nombre="ccf";
        $correlativo->serie="";
        $correlativo->desde="1";
        $correlativo->hasta="10000";
        $correlativo->ultimo="0";
        $correlativo->cantidad="10000";
        $correlativo->id_sucursal="1";
        $correlativo->save();

        $correlativo= new Correlativo();
        $correlativo->nombre="cliente";
        $correlativo->ultimo="0";
        $correlativo->id_sucursal="1";
        $correlativo->save();
        
        $correlativo= new Correlativo();
        $correlativo->nombre="tv";
        $correlativo->ultimo="0";
        $correlativo->id_sucursal="1";
        $correlativo->save();

        $correlativo= new Correlativo();
        $correlativo->nombre="inter";
        $correlativo->ultimo="0";
        $correlativo->id_sucursal="1";
        $correlativo->save();

        $correlativo= new Correlativo();
        $correlativo->nombre="orden";
        $correlativo->ultimo="0";
        $correlativo->id_sucursal="1";
        $correlativo->save();

        $correlativo= new Correlativo();
        $correlativo->nombre="traslado";
        $correlativo->ultimo="0";
        $correlativo->id_sucursal="1";
        $correlativo->save();

        $correlativo= new Correlativo();
        $correlativo->nombre="reconexion";
        $correlativo->ultimo="0";
        $correlativo->id_sucursal="1";
        $correlativo->save();

        $correlativo= new Correlativo();
        $correlativo->nombre="suspension";
        $correlativo->ultimo="0";
        $correlativo->id_sucursal="1";
        $correlativo->save();
    }
}
