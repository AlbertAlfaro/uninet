<?php

namespace App\Imports;
use App\Models\Abono;
use Carbon\Carbon;
use DateTime;
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
            'id_cliente' => $row[5],
            'numero_documento' => $row[0].$row[1],
            'mes_servicio' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'abono' => $row[3],
            'cesc_abono' => $row[4],
            'precio' => $row[3],
            'anulado' => '0',
            'pagado' => '1',

            
           
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
