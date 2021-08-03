<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sucursal extends Model
{
    use HasFactory;

    public function get_municipio()
    {
        return $this->hasOne('App\Models\Municipios','id', 'id_municipio');
    }
}
