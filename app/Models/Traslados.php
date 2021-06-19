<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traslados extends Model
{
    use HasFactory;
    protected $dates = ['fecha_trabajo'];
    public function get_cliente()
    {
        return $this->hasOne('App\Models\Cliente','id','id_cliente');
    }
    public function get_tecnico()
    {
        return $this->hasOne('App\Models\Tecnicos','id','id_tecnico');
    }
    public function get_municipio()
    {
        return $this->hasOne('App\Models\Municipios','id', 'id_municipio');
    }
}
