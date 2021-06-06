<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $dates = ['fecha_nacimiento'];

    public function get_municipio()
    {
        return $this->hasOne('App\Models\Municipios','id', 'id_municipio');
    }



}
