<?php

namespace App\Imports;

use App\Models\Cliente;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientesImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Cliente([
            'id' => $row[0],
            'codigo' => $row[1],
            'nombre'    => $row[2], 
            'dui' => $row[5],
            'nit' => $row[6],
            'telefono1' => $row[4],
            'id_municipio' => $row[7],
            'dirreccion' => $row[3],
            'dirreccion_cobro' => $row[3],
            'ocupacion' => $row[8],
            'colilla' => $row[10],
            'tv' => $row[11],
            'internet' => $row[10],
            'activo' => $row[9],
            'id_sucursal' => $row[10],
           
         ]);

         /*
         0 id
         1 codigo
         2 nombre 
         3 direccion
         4 telefono
         5 dui
         6 nit 
         7 id_municipio
         8 ocupacion
         9 activo
         10 colilla o igual 1
         11 igual 0

         */
    }
}
