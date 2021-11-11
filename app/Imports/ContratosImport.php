<?php

namespace App\Imports;

use App\Models\Internet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ContratosImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Internet([
            'id_cliente' => $row[0],
            'numero_contrato' => $row[1], 
            'fecha_instalacion' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'fecha_primer_fact' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'cuota_mensual' => $row[16],
            'dia_gene_fact' => $row[4],
            'contrato_vence' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]),
            'periodo' => $row[6],
            'velocidad' => $row[14],
            'onu' => $row[7],
            'onu_wifi' => $row[8],
            'cable_red' => $row[9],
            'router' => $row[10],
            'identificador' => 1,
            'activo' => $row[15],
           
         ]);
    }
}
