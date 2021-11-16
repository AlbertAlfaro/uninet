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
            /*'id_cliente' => $row[0],
            'tipo_servicio' => '1',
            'numero_documento' => $row[4].$row[5],
            'mes_servicio' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'cargo' => $row[6],
            'abono' => '0.00',
            'cesc_cargo' => $row[7],
            'precio' => $row[6],
            'anulado' => '0',
            'pagado' => '1',*/

            /*PARA GENERAR LOS ABONOS*/
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
         ]);
    }
}
