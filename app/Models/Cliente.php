<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $dates = ['fecha_nacimiento'];
    protected $fillable = ['id', 'codigo','nombre','email','dui','nit','fecha_nacimiento','telefono1','telefono2','id_municipio','dirreccion','dirreccion_cobro','ocupacion','condicion_lugar','nombre_dueno','numero_registro','giro','colilla','tipo_documento','referencia1','telefo1','referencia2','telefo2','referencia3','telefo3','tv','internet','cordenada','nodo','activo','id_sucursal'];

    public function get_municipio()
    {
        return $this->hasOne('App\Models\Municipios','id', 'id_municipio');
    }

    

}
