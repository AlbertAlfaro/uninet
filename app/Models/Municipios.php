<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    use HasFactory;

    public function get_departamento(){

        return $this->hasOne('App\Models\Departamentos','id', 'id_departamento');

    }
}
