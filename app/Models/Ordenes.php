<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    use HasFactory;
    protected $dates = ['fecha_trabajo'];
    public function get_cliente()
    {
        return $this->hasOne('App\Models\Cliente','id','id_cliente');
    }
    public function get_actividad()
    {
        return $this->hasOne('App\Models\Actividades','id','id_actividad');
    }
    public function get_tecnico()
    {
        return $this->hasOne('App\Models\Tecnicos','id','id_tecnico');
    }
    public function get_usuario()
    {
        return $this->hasOne('App\Models\User','id','id_usuario');
    }
}
