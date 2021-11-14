<?php

namespace App\Imports;
use App\Models\Abono;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class AbonosImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Abono([
            /*PARA GENERAR LOS CARGOS*/
            'id_cliente' => $row[0],
            'tipo_servicio' => '1',
            'numero_documento' => $row[4].$row[5],
            'mes_servicio' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'cargo' => $row[6],
            'abono' => '0.00',
            'cesc_cargo' => $row[7],
            'precio' => $row[6],
            'anulado' => '0',
            'pagado' => '1',

            /*PARA GENERAR LOS ABONOS
            'id_cliente' => $row[0],
            'tipo_servicio' => '1',
            'numero_documento' => $row[4].$row[5],
            'mes_servicio' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'cargo' => '0.00',
            'abono' => $row[6],
            'cesc_abono' => $row[7],
            'precio' => $row[6],
            'anulado' => '0',
            'pagado' => '1',
            */

            
           
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
