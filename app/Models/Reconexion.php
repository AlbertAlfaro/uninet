<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reconexion extends Model
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
}
