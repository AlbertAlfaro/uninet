<?php

namespace App\Imports;

use App\Models\test;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToModel;

class TestImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new test([
           'id'     => $row[0],
           'nombre'    => $row[1], 
           'apellido' => $row[2],
        ]);
    }
}
